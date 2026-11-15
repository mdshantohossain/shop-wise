<?php

namespace App\Http\Middleware;

use App\Models\UserSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $payload = auth('api')->payload();

       $sessionId = $payload->get('sid');

       $jti = $payload->get('jti');

       if(!$sessionId || !$jti) {
           return response()->json([
               'success' => false,
               'message' => 'Invalid Session'
           ],  401);
       }

       $session = UserSession::where('session_id', $sessionId)
           ->where('user_id', auth()->user()->id)
           ->where('token_id', $jti)
           ->whereNull('revoked_at')
           ->where('expires_at', '>', now())
           ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired or revoked.',
            ], 401);
        }

       return $next($request);
    }
}
