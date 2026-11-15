<?php

namespace App\Services;

use App\Events\SellerRegisteredEvent;
use App\Http\Requests\SellerRegisterRequest;
use App\Models\User;
use App\Models\UserSession;
use App\Models\UserSessionToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Random\RandomException;
use function Symfony\Component\String\u;

class AuthService
{
    protected RabbitMQPublisher $publisher;

    public function __construct(RabbitMQPublisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @param array{
     *      name: string,
     *      email: string,
     *      password: string,
     *      role: string
     * } $inputs
     * @throws \Throwable
     */
    public function register(array $inputs): User
    {
        $user = DB::transaction(function () use ($inputs) {

            // create user
            $user = User::create([
                'name' => $inputs['name'],
                'email' => $inputs['email'],
                'password' => bcrypt($inputs['password']),
                'role' => $inputs['role'],
            ]);

            // create seller
            if($user->role === 'seller') {

                // dispatch to create seller account
                SellerRegisteredEvent::dispatch([
                    'user_id' => $user->id,
                    'store_name' => $inputs['store_name'],
                    'seller_type' => $inputs['seller_type'],
                    'store_phone' => $inputs['store_phone'],
                    'store_email' => $inputs['store_email'],
                    'description' => $inputs['description'],
                    'city' => $inputs['city'],
                    'state' => $inputs['state'],
                    'address' => $inputs['address'],
                ]);
            }

            return $user;

        });

        // message broker
        $this->publisher->publish('user.registered', [
            'event_id' => (string) Str::uuid(),
            'event' => 'UserRegistered',
            'data' => $user,
        ]);

        return $user;
    }

    /**
     * @param array{
     *      email: string,
     *      password: string,
     * } $inputs
     *
     * @return array
     * @throws \Throwable
     */
    public function login(array $inputs): array
    {
        $user = User::where('email', $inputs['email'])->first();

        // Check authentication
        if (!$user || !Hash::check(
                $inputs['password'],
                $user->password
            )) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        // Check pending account
        if ($user->status === 0) {
            throw ValidationException::withMessages([
                'email' => ['Please verify your email first.'],
            ]);
        }

        // Check suspended account
        if ($user->status === 2) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been suspended.'],
            ]);
        }

       return DB::transaction(function () use ($user, $inputs) {

           $session = UserSession::create([
               'user_id' => $user->id,
               'session_id' => (string) Str::uuid(),
               'device_name' => $inputs['device_name'],
               'device_type' => $inputs['device_type'],
               'ip_address' => request()->ip(),
               'user_agent' => request()->userAgent(),
               'expires_at' => config('authentication.refresh_ttl'),
               'used_at' => now(),
           ]);

           return $this->issueCredentials($user, $session);

       });
    }

    /**
     * @throws RandomException
     */
    public function issueCredentials(
        User $user,
        UserSession $session
    ): array
    {
        $accessToken = auth('api')
            ->claims([
                'sid' => $session->session_id,
            ])
            ->login($user);

        $payload = auth('api')->payload();

        $jti = $payload->get('jti');

        $refreshToken = bin2hex(random_bytes(48));

        UserSessionToken::create([
            'user_session_id' => $session->id,
            'token_hash' => hash('sha256', $refreshToken),
            'expires_at' => $session->expires_at,
        ]);

        $session->update([
            'token_id' => $jti
        ]);

        return [
            'user' => $user,
            'session_id' => $session->session_id,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => config('authentication.refresh_ttl'),
        ];
    }

    /**
     * Rotate refresh token and issue a new access token.
     */
    public function refresh(string $refreshToken): array
    {
        $hash = hash('sha256', $refreshToken);

        $result = DB::transaction(function () use ($hash) {

            $tokenRecord = UserSessionToken::where(
                'token_hash',
                $hash
            )->lockForUpdate()->first();

            if (!$tokenRecord) {
                return ['invalid' => true];
            }

            $session = UserSession::whereKey(
                $tokenRecord->user_session_id
            )->lockForUpdate()->first();

            if (!$session) {
                return ['invalid' => true];
            }

            // Detect refresh token reuse
            if (
                $tokenRecord->used_at !== null ||
                $tokenRecord->revoked_at !== null
            ) {
                $session->update([
                    'revoked_at' => now(),
                    'token_id' => null,
                ]);

                $session->tokens()
                    ->whereNull('revoked_at')
                    ->update([
                        'revoked_at' => now(),
                    ]);

                return ['reuse_detected' => true];
            }

            if (
                $session->revoked_at !== null ||
                $session->expires_at->isPast() ||
                $tokenRecord->expires_at->isPast()
            ) {
                return ['invalid' => true];
            }

            $user = $session->user;

            if (!$user || (int) $user->status !== 1) {
                $session->update([
                    'revoked_at' => now(),
                    'token_id' => null,
                ]);

                return ['invalid' => true];
            }

            // Mark previous refresh token as used
            $tokenRecord->update([
                'used_at' => now(),
            ]);

            // Generate next token pair
            $credentials = $this->issueCredentials(
                $user,
                $session
            );

            // Link old token to new token
            $newTokenRecord = UserSessionToken::where(
                'token_hash',
                hash('sha256', $credentials['refresh_token'])
            )->firstOrFail();

            $tokenRecord->update([
                'replaced_by_id' => $newTokenRecord->id,
            ]);

            $session->update([
                'last_used_at' => now(),
            ]);

            return [
                'credentials' => $credentials,
            ];
        });

        if (isset($result['reuse_detected'])) {
            throw ValidationException::withMessages([
                'refresh_token' => [
                    'Refresh token reuse detected. Please login again.',
                ],
            ]);
        }

        if (isset($result['invalid'])) {
            throw ValidationException::withMessages([
                'refresh_token' => ['Invalid or expired session.'],
            ]);
        }

        return $result['credentials'];
    }

    /**
     * Revoke a device session.
     * @throws \Throwable
     */
    public function logout(string $refreshToken): void
    {
        DB::transaction(function () use ($refreshToken) {

            $token = UserSessionToken::where(
                'token_hash',
                hash('sha256', $refreshToken)
            )->lockForUpdate()->first();

            if (!$token) {
                return;
            }

            $session = UserSession::whereKey(
                $token->user_session_id
            )->lockForUpdate()->first();

            if (!$session) {
                return;
            }

            $session->update([
                'revoked_at' => now(),
                'token_id' => null,
            ]);

            $session->tokens()
                ->whereNull('revoked_at')
                ->update([
                    'revoked_at' => now(),
                ]);
        });
    }

    /**
     * Revoke all active sessions of a user.
     */
    public function logoutAll(User $user): void
    {
        DB::transaction(function () use ($user) {

            $sessions = UserSession::where('user_id', $user->id)
                ->whereNull('revoked_at')
                ->lockForUpdate()
                ->get();

            foreach ($sessions as $session) {

                $session->update([
                    'revoked_at' => now(),
                    'token_id' => null,
                ]);

                $session->tokens()
                    ->whereNull('revoked_at')
                    ->update([
                        'revoked_at' => now(),
                    ]);
            }
        });
    }

}
