<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Evencalender;
use App\Models\Company;
use App\Models\CategoryEvencalender;
use App\Models\Kecamatan;
use App\Models\HargaTiket;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEvencalenderRequest;
use App\Http\Requests\StoreEvencalenderRequest;
use App\Http\Requests\UpdateEvencalenderRequest;
use Gate;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response;

class EvencalenderController extends Controller
{
    use MediaUploadingTrait;

    public function getAllEvencalenders()
    {
        $hash = new Hashids();
        $evencalenders = Evencalender::all();
        return view('admin.evencalender.index', compact('evencalenders', 'hash'));
    }

    public function storeEvencalender(Request $request)
    {
        try {
            $evencalender = Evencalender::create($request->all());
    
            foreach ($request->input('photos', []) as $file) {
                $evencalender->addMedia(storage_path('tmp/uploads/' . $file))
                    ->withCustomProperties([
                        'width' => 6250,
                        'height' => 4419
                    ])
                    ->toMediaCollection('photos');
            }
    
            Log::info('Evencalender created successfully', ['evencalender_id' => $evencalender->id]);
    
            return redirect()->route('admin.evencalender.index');
        } catch (\Exception $e) {
            Log::error('Error creating evencalender', ['error' => $e->getMessage()]);
            return back()->withError('Error creating evencalender')->withInput();
        }
    }



    public function createEvencalender()
    {

        return view('admin.evencalender.create');
    }

    public function showevencalender($evencalender)
    {
        $hash = new Hashids();
        $evencalender = Evencalender::find($hash->decodeHex($evencalender));
        return view('admin.evencalender.show', compact('evencalender', 'hash'));
    }



    public function massDestroy(MassDestroyEvencalenderRequest $request)
    {
        Evencalender::whereIn('id', request('ids'))->delete();
        if (count($evencalender->photos) > 0) {
            foreach ($evencalender->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();
    }

    public function destroy(Request $request, $evencalender)
    {
        $hash = new Hashids();
        $evencalender = Evencalender::find($hash->decodeHex($evencalender));
        $evencalender->delete();
        if (count($evencalender->photos) > 0) {
            foreach ($evencalender->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editevencalender($evencalender)
    {
        $hash = new Hashids();
        $evencalender = Evencalender::find($hash->decodeHex($evencalender));
        return view('admin.evencalender.edit', compact('evencalender'))->with([
            'evencalender' => $evencalender,
            'hash' => $hash
        ]);
    }

    public function evencalenderupdate(Request $request, $evencalender)
    {
        try {
            if (!$request->active) {
                $request->merge([
                    'active' => 0
                ]);
            }
    
            $hash = new Hashids();
            $decodedId = $hash->decodeHex($evencalender);
            $evencalender = Evencalender::find($decodedId);
            $evencalender->update($request->all());
    
            if (count($evencalender->photos) > 0) {
                foreach ($evencalender->photos as $media) {
                    if (!in_array($media->file_name, $request->input('photos', []))) {
                        $media->delete();
                    }
                }
            }
    
            $media = $evencalender->photos->pluck('file_name')->toArray();
    
            foreach ($request->input('photos', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $evencalender->addMedia(storage_path('tmp/uploads/' . $file))
                        ->withCustomProperties([
                            'width' => 4419,
                            'height' => 6250
                        ])
                        ->toMediaCollection('photos');
                }
            }
    
            Log::info('Evencalender updated successfully', ['evencalender_id' => $decodedId]);
    
            return redirect()->route('admin.evencalender.index');
        } catch (\Exception $e) {
            Log::error('Error updating evencalender', ['error' => $e->getMessage()]);
            return back()->withError('Error updating evencalender')->withInput();
        }
    }
}
