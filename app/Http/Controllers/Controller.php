<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function getWeatherData($latitude, $longitude)
    {
        $accessToken = env('OPENWEATHER_TOKEN');

        $response = Http::get("http://api.openweathermap.org/data/2.5/weather?lat=$latitude&lon=$longitude&limit=5&appid=$accessToken");

        return $response->json();
    }

    public function chooseWeatherImage($weatherCode)
    {
        // Lakukan pemetaan antara kode cuaca dan gambar cuaca yang sesuai
        switch ($weatherCode) {
            case '01d':
            case '01n':
                return 'w_3.png'; // Contoh gambar untuk langit cerah
            case '02d':
            case '02n':
                return 'w_4.png'; // Contoh gambar untuk awan sedikit
            case '03d':
            case '03n':
            case '04d':
            case '04n':
                return 'w_10.png'; // Contoh gambar untuk mendung
            case '09d':
            case '09n':
            case '10d':
            case '10n':
                return 'w_80.png'; // Contoh gambar untuk hujan
                // Tambahkan kasus lain sesuai kebutuhan
            default:
                return 'default-image.jpg'; // Gambar default jika kode cuaca tidak cocok
        }
    }


}

