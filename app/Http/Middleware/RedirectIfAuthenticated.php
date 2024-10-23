<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            if ($user->hasRole('admin')) {
                return redirect('/admin/dashboard');
            } elseif ($user->hasRole('wisata')) {
                return redirect('/wisata/dashboard');
            } elseif ($user->hasRole('kuliner')) {
                return redirect('/kuliner/dashboard');
            } elseif ($user->hasRole('ekraf')) {
                return redirect('/ekraf/dashboard');
            } elseif ($user->hasRole('akomodasi')) {
                return redirect('/akomodasi/dashboard');
            } elseif ($user->hasRole('guide')) {
                return redirect('/guide/dashboard');
            }
            
        }
    }

    return $next($request);
}
}
