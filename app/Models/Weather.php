<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Weather extends Model
{
    public static function getWeatherData($latitude, $longitude)
    {
        $accessToken = env('OPENWEATHER_TOKEN');

        $response = Http::get("http://api.openweathermap.org/data/2.5/weather?lat=$latitude&lon=$longitude&limit=5&appid=$accessToken");

        return $response->json();
    }

}
