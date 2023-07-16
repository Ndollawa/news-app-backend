<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $jwtToken = $request->cookie('jwt');
// dd($jwtToken);
        if ($jwtToken) {
            try {
                $user = JWTAuth::parseToken()->authenticate();

                if ($user) {
                    // Set the authenticated user in the Laravel Auth facade
                    Auth::setUser($user);
                }
            } catch (\Exception $e) {
                // Handle token validation errors
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }

        return $next($request);
    }
}
