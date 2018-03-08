<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (!auth()->guard($guard)->check()) {
            $request->session()->flash('error', 'You must be an employee to see this page');
            return redirect(route('admin.login'));
        }

        return $next($request);
    }
}
