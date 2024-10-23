<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function logLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        Log::info('User location logged', $location);

        return response()->json(['message' => 'Location logged successfully'], 200);
    }
}
