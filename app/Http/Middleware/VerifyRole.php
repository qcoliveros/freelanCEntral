<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $authenticatedUserRole = $request->user()->getRoleNames()[0] ?? '';
        if (($role == 'admin' && $authenticatedUserRole != 'Administrator')
            or ($role == 'gigger' && $authenticatedUserRole != 'Gigger')
            or ($role == 'gigHost' && $authenticatedUserRole != 'Gig Host'))
        {
            abort(403);
        }

        return $next($request);
    }
}
