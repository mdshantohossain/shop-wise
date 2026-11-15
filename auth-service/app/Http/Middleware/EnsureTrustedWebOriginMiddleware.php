<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTrustedWebOriginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->header('Origin');

        $allowedOrigins = config('authentication.web_origins');

        if(!$origin || !in_array($origin, $allowedOrigins, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Untrusted request origin.',
            ], 403);
        }

        return $next($request);
    }
}
