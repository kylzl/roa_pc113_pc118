<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AllowedRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, $roles, Closure $next): Response
    {   
       $user = $request->user();
         if ($user->role !== 'admin') {
              return next($request);
            }if (!in_array($user->role, $roles)) {
                return response()->json(['message' => 'You are not allowed to access this route'], 403);
            }
        return $next($request);
    }
}
