<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccepted
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->accepted) {
            Auth::guard('admin')->logout();
            return redirect('admin/login');
        }

        $defaultGuard = Auth::getDefaultDriver();
        $request->attributes->set('defaultGuard', $defaultGuard);
 
        return $next($request);
    }
}