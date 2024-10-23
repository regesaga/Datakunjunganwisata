<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Baner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BanerApiController extends Controller
{
    public function index()
    {
        $banners = Baner::where('judul', 'mobile')->get();

        // Menambahkan URL thumbnail ke setiap banner
        $banners->map(function ($banner) {
            $banner->thumbnail_url = $banner->getThumbnailUrl(); // Metode untuk mendapatkan URL thumbnail
            return $banner;
        });

        return response()->json([
            'message' => 'Banner',
            'success' => true,
            'data' => $banners
        ], 200);
    }
}
