<?php

namespace App\Http\Controllers;

use App\Models\Youtube;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function index()
    {
        try {
            $datas = Youtube::limit(11)->get();

            foreach ($datas as $item) {
                $item->thumbnails = json_decode($item->thumbnails, true);
            }

            return view('youtube', compact('datas'));

        } catch (\Throwable $th) {
            return view('errors.500');
        }
        
    }
}
