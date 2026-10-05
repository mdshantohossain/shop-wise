<?php

namespace App\Services;

use App\Events\UserRegisteredEvent;
use App\Models\EmailVerification;
use App\Models\RefreshAccessToken;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    private MailService $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @param array{
     *      email: string,
     *      password: string,
     *      phone: string,
     *      street_address?: string,
     *      city?: string,
     *      state?: string,
     *      zipcode?: string} $data
     * @return array
     * @throws \Throwable
     */
    public function login(array $data): array
    {
        try {
            $user = User::where('email', $data['email'])
                ->with('addresses')
                ->withCount('orders')
                ->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                return [
                    'success' => false,
                    'message' => 'Invalid credentials',
                    'status' => 401
                ];
            }

            if($user->email_verified_at == null) {
                return [
                    'success' => false,
                    'message' => 'Your email address is not verified. Please check your inbox and follow the verification link to activate your account.',
                    'status' => 403
                ];
            }

            if ($user->status == 0) {
                return [
                    'success' => false,
                    'message' => 'You are blocked user. Please contact with support.',
                    'status' => 403
                ];
            }

            // update phone if exists
            if(!empty($data['phone'])){
                $user->update(['phone' => $data['phone']]);
            }

            // auth access token
            $accessToken  = $user->createToken('auth_token');

            // refresh token access token to refresh old access token
            $refreshToken = bin2hex(random_bytes(40));

            RefreshAccessToken::create([
                'user_id' => $user->id,
                'refresh_token' => hash('sha256', $refreshToken),
                'access_token_id' => $accessToken->accessToken->id,
                'expires_in' => now()->addDays(7),
            ]);

            // create address this will fire when user sign in or signup from checkout
            if(isset($data['street_address'])) {
                $this->createAddress($data, $user->id);
            }

            return [
                'payload' => [
                    'token' => $accessToken->plainTextToken,
                    'user' => $user,
                ],
                'refresh_token' => $refreshToken,
            ];

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /**
     * Register a new user and save address also if included.
     *
     * @param array{
     *     name: string,
     *     email: string,
     *     password: string,
     *     phone?: string|null,
     *     country?: string|null,
     *     street_address?: string,
     *     city?: string,
     *     state?: string,
     *     zipcode?: string
     * } $data
     *
     * @return User
     * @throws \Throwable
     */
    public function register(array $data): User
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => bcrypt($data['password']),
                'role' => 'user'
            ]);

            if(isset($data['street_address'])) {
                $this->createAddress($data, $user->id);
            }

            $token = EmailVerification::create([
                'user_id'    => $user->id,
                'token'      => Str::uuid(),
                'expires_at' => now()->addMinutes(30),
            ]);

            // events occurs
            event(new UserRegisteredEvent($user, $token->token));

            return $user;
        } catch (\Throwable $e) {
            report($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    public function verifyEmail(string $token): JsonResponse
    {
        try {
            $record = EmailVerification::where('token', $token)
                ->where('expires_at', '>', now())
                ->first();

            if(! $record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your verification link has expired. Please request a new one.',
                ], 400);
            }

            // If already verified
            if ($record->user->email_verified_at) {
                $record->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Your email is already verified.',
                ]);
            }

            // update verify time
            $record->user->update(['email_verified_at' => now()]);

            $record->delete();

            // send welcome email
            $this->mailService->welcomeMail($record->user);

            return response()->json([
                'success' => true,
                'message' => 'Email has been verified successfully. Login to continue.',
            ]);

        } catch (\Throwable $exception) {
            logger($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Create address .
     *
     * @param array{
     *     phone: string,
     *     street_address?: string,
     *     city?: string,
     *     state?: string,
     *     zipcode?: string
     * } $data
     * @param int $userId
     * @return void
     */
    public function createAddress(array $data, int $userId): void
    {
        UserAddress::create([
            'user_id' => $userId,
            'phone' => $data['phone'],
            'street_address' => $data['street_address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zipcode' => $data['zipcode'],
        ]);
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    public function resendVerifyEmail(string $token): JsonResponse
    {
        try {
            if (! $token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token is required',
                ], 404);
            }

            $record = EmailVerification::firstWhere('token', $token);

            if (! $record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired token. Please register again.',
                ], 400);
            }

            $user = $record->user;

            // Delete old token and generate new one
            $record->delete();

            // if already verified
            if ($user->email_verified_at) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your email is already verified.',
                ]);
            }

            $token = EmailVerification::create([
                'user_id'    => $user->id,
                'token'      => Str::uuid(),
                'expires_at' => now()->addMinutes(30),
            ]);

            // event occurs
            event(new UserRegisteredEvent($user, $token->token));

            return response()->json([
                'success' => true,
                'message' => "We’ve sent a password reset link to your email address. Please check
                              your inbox and follow the instructions to reset your password.",
            ], 201);
        } catch (\Throwable $exception) {
            logger($exception->getMessage());
            return response()->json([
                'success' => false,
                'message'  => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function createNewPassword(array $data): JsonResponse
    {
        try {
            $record = DB::table('password_reset_tokens')
                ->where('token', $data['token'])
                ->first();

            if(! $record) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid or expired token."
                ], 400);
            }

            $user = User::firstWhere('email', $record->email);

            if(! $user) {
                return response()->json([
                    'success' => false,
                    'message' => "User not requested for forgot password."
                ], 400);
            }

            $user->password = Hash::make($data['password']);
            $user->save();

            // delete token after verification
            DB::table('password_reset_tokens')->where('token', $data['token'])->delete();

            return response()->json([
                'success' => true,
                'message' => "Password reset successful."
            ], 201);
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logout(): JsonResponse
    {
        $user = request()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $currenToken = $user->currentAccessToken();

        if($currenToken) {
            RefreshAccessToken::where('user_id', $user->id)->where('access_token_id', $currenToken->id)->delete();
            $currenToken->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out'
        ])->cookie('refresh_token', '', -1); // delete cookie
    }
}
