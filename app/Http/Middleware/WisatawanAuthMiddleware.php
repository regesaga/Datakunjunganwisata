<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WisatawanAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('wisatawans')->check()) {
            return redirect(route('wisatawan.login'));
        }
        return $next($request);

        // Jika tidak, coba untuk melakukan login dengan email
        if (Auth::guard('wisatawans')->attempt(['email' => $request->username, 'password' => $request->password])) {
            return $next($request);
        }

        // Jika tidak berhasil, coba untuk melakukan login dengan phone
        if (Auth::guard('wisatawans')->attempt(['phone' => $request->username, 'password' => $request->password])) {
            return $next($request);
        }

        // Jika tidak berhasil, coba untuk melakukan login dengan name
        if (Auth::guard('wisatawans')->attempt(['name' => $request->username, 'password' => $request->password])) {
            return $next($request);
        }
        // Jika tidak berhasil dengan kedua cara, kembalikan response yang sesuai
        return redirect()->route('wisatawan.login');
    }
}
