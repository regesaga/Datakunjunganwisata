<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEvencalenderRequest;
use App\Http\Requests\UpdateEvencalenderRequest;
use App\Http\Resources\EvencalenderResource;
use App\Models\Evencalender;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EvencalenderApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //get all posts
        $evencalenders = Evencalender::all();
        return response()->json(['messages' => 'Data Evencalender','success' => true, 'data' => EvencalenderResource::collection($evencalenders)], 200);
    }

    function get($id = null)
    {
        if (isset($id)) {
            $evencalender = Evencalender::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $evencalender], 200);
        } else {
            $evencalenders = Evencalender::get();
            return response()->json(['messages' => 'Data Evencalender','success' => true, 'data' => $evencalenders], 200);
        }
    }

    

    function show($id)
    {
        
        if (isset($id)) {
            $evencalender = Evencalender::findOrFail($id);
            return response()->json(['messages' => 'Data diambil','success' => true, 'data' => $evencalender], 200);
        } else {
            $evencalenders = Evencalender::get();
            return response()->json(['messages' => 'Data Evencalender','success' => true, 'data' => $evencalenders], 200);
        }
    }

   
}
