<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogUserAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Mendapatkan IP asli dari header X-Forwarded-For
        $ip = $request->header('X-Forwarded-For', $request->ip());

        // Mendapatkan lokasi pengguna (gunakan API eksternal misalnya)
        $location = $this->getUserLocation($ip);

        // Mencatat informasi akses ke dalam log
        Log::info("User accessed kuninganbeu", [
            'ip' => $ip,
            'location' => $location,
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
        ]);

        return $next($request);
    }

    private function getUserLocation($ip)
    {
        // Implementasikan logika untuk mendapatkan lokasi berdasarkan IP
        // Misalnya, menggunakan layanan eksternal seperti IP geolocation API

        return "Unknown"; // Ganti dengan informasi lokasi yang sebenarnya
    }
}
