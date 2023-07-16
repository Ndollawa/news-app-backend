<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\JsonResponse)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
    
        return $next($request);
    }
    
}
