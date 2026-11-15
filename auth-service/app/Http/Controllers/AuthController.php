<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\UserSession;
use App\Services\AuthService;
use App\Supports\AuthCookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function me()
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource(auth()->user()),
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function register(UserRegisterRequest $request, AuthService $authService)
    {
        $inputs = $request->validated();

        $inputs['role'] = 'user';

        $authService->register($inputs);

        return response()->json([
            'success' => true,
            'message' => 'Registration successfully'
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function login(LoginRequest $request, AuthService $authService)
    {
        $inputs = $request->validated();

        return response()->json([
            'success' => true,
            'data' => $inputs
        ]);

        // login
        $res = $authService->login($inputs);

        $data = [
            'user' => new UserResource($res['user']),
            'access_token' => $res['access_token'],
            'expires_in' => $res['expires_in'],
        ];

        if($inputs['device_type'] === 'web') {
            return response()->json([
                'success' => true,
                'message' => 'Login successful',

                'data' => $data,
            ])->withCookie(
                AuthCookie::make($res['refresh_token'])
            );
        }

        $data['refresh_token'] = $res['refresh_token'];

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $data
        ]);
    }

    public function webRefreshToken(Request $request, AuthService $authService)
    {
        $refreshToken = $request->cookie(
            config('authentication.cookie_name')
        );

        if(!$refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token not found',
            ], 404);
        }

        $credentials = $authService->refresh($refreshToken);

        if($credentials['invalid'])
        {
            return response()->json([
                'success' => false,
                'message' => 'Invalid refresh token',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $credentials['access_token'],
                'expires_in' => $credentials['expires_in'],
            ]
        ], 201)->withCookie(
            AuthCookie::make($credentials['refresh_token'])
        );
    }

    public function mobileRefreshToken(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'refresh_token' => ['required', 'string'],
        ]);

        $credentials = $authService->refresh(
            $validated['refresh_token']
        );

        if($credentials['invalid'])
        {
            return response()->json([
                'success' => false,
                'message' => 'Invalid refresh token',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $credentials['access_token'],
                'refresh_token' => $credentials['refresh_token'],
                'expires_in' => $credentials['expires_in'],
            ],
        ]);
    }

    public function webLogout(Request $request, AuthService $authService)
    {
        $refreshToken = $request->cookie(
            config('authentication.cookie_name')
        );

        if ($refreshToken) {
            $authService->logout($refreshToken);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ])->withCookie(AuthCookie::forget());
    }

    /**
     * @throws \Throwable
     */
    public function mobileLogout(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'refresh_token' => ['required', 'string'],
        ]);

        $authService->logout($validated['refresh_token']);

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }

    public function logoutAll(Request $request, AuthService $authService)
    {
        $authService->logoutAll($request->user());

        return response()->json([
            'success' => true,
            'message' => 'All sessions revoked.',
        ]);
    }

    public function sessions(Request $request)
    {
        $sessions = UserSession::where(
            'user_id',
            $request->user()->id
        )
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->latest('last_used_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sessions,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function revokeSession(
        Request $request,
        string $sessionId
    ) {
        DB::transaction(function () use ($request, $sessionId) {

            $session = UserSession::where(
                'user_id',
                $request->user()->id
            )
                ->where('session_id', $sessionId)
                ->lockForUpdate()
                ->firstOrFail();

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

        return response()->json([
            'success' => true,
            'message' => 'Session revoked successfully.',
        ]);
    }
}
