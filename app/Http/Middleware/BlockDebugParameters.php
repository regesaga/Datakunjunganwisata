<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockDebugParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('XDEBUG_SESSION_START')) {
            return response('Access Denied.', 403);
        }

        return $next($request);
    }
}
