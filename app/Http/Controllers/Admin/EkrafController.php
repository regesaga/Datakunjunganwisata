<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Ekraf;
use App\Models\Company;
use App\Models\SektorEkraf;
use App\Models\Fasilitas;
use App\Models\Kecamatan;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEkrafRequest;
use App\Http\Requests\StoreEkrafRequest;
use App\Http\Requests\UpdateEkrafRequest;

use Gate;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response;

class EkrafController extends Controller
{
    use MediaUploadingTrait;


    public function getAllEkrafs()
    {
        $hash=new Hashids();
        $ekrafs = Ekraf::all();
        $sektorekraf = SektorEkraf::all();
        return view('admin.ekraf.index', compact('ekrafs','hash', 'sektorekraf'));
    }

    public function storeEkraf(Request $request)
    {
        
        $ekraf = Ekraf::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $ekraf->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }




        return redirect()->route('admin.ekraf.index');


    }
            



    public function createEkraf()
    {
        
        $company = Company::all();
        $sektorekraf = SektorEkraf::all();
        
        $kecamatan = Kecamatan::all();
        return view('admin.ekraf.create',  compact('company', 'sektorekraf','kecamatan'));
    }

    public function showekraf($ekraf)
    {
        $hash=new Hashids();
        $ekraf = Ekraf::find($hash->decodeHex($ekraf));
        return view('admin.ekraf.show', compact('ekraf','hash'));
    }






    public function massDestroy(MassDestroyEkrafRequest $request)
    {
        Ekraf::whereIn('id', request('ids'))->delete();
        if (count($ekraf->photos) > 0) {
            foreach ($ekraf->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }

    public function destroy(Request $request,$ekraf)
    {
        $hash=new Hashids();
        $ekraf = Ekraf::find($hash->decodeHex($ekraf));
        $ekraf->delete();
        if (count($ekraf->photos) > 0) {
            foreach ($ekraf->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editekraf($ekraf)
    {
        $company = Company::all();
        
        $hash=new Hashids();
        $ekraf = Ekraf::find($hash->decodeHex($ekraf));
        $sektorekraf = SektorEkraf::all();
        $kecamatan = Kecamatan::all();
        return view('admin.ekraf.edit', compact( 'ekraf','company', 'sektorekraf','kecamatan'))->with([
            'ekraf' => $ekraf,
            'company' => $company,
            'kecamatan' => $kecamatan,
            'sektorekraf' => $sektorekraf,
            'hash' => $hash
        ]);
    }
  
    public function ekrafupdate(Request $request, $ekraf)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash=new Hashids();
        $ekraf = Ekraf::find($hash->decodeHex($ekraf));
        $newEkraf = $ekraf->update($request->all());

        

        if (count($ekraf->photos) > 0) {
            foreach ($ekraf->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $ekraf->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $ekraf->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.ekraf.index');
    }
}
