<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class UserType
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {

        $defaultGuard = Auth::getDefaultDriver();
        $request->merge(['user_type' => $defaultGuard]);
 
        return $next($request);
    }
}