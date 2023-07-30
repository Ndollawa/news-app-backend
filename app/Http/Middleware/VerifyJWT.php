<?php

namespace App\Http\Middleware;

use App\Traits\v1\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class VerifyJWT
{

    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\JsonResponse)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $jwtCookie = $request->cookie('jwt');
        if(!$jwtCookie){
            return $this->error(['message' =>'Unauthorized'],null,401);
        }
        $request->headers->set('Authorization', "Bearer {$jwtCookie}");
        return $next($request);
    }
}
