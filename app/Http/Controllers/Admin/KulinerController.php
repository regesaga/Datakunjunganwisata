<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert; 
use Illuminate\Http\Request;
use App\Models\CategoryKuliner;
use App\Models\Kuliner;
use App\Models\Company;
use App\Models\Kecamatan;
use App\Models\RekomendasiKuliner;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyKulinerRequest;
use App\Http\Requests\StoreKulinerRequest;
use App\Http\Requests\UpdateKulinerRequest;
use App\Models\Weather;
use Gate;
use Hashids\Hashids;

use Symfony\Component\HttpFoundation\Response;

class KulinerController extends Controller


{
    use MediaUploadingTrait;


    public function getAllKuliners()
    {
        $hash=new Hashids();
        $categories = CategoryKuliner::all();
        $kecamatan = Kecamatan::all();
        $kuliners = Kuliner::all();
        return view('admin.kuliner.index', compact('kuliners','categories','hash','kecamatan'));
    }

    public function storeKuliner(Request $request)
    {
        
        $kuliner = Kuliner::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $kuliner->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }




        return redirect()->route('admin.kuliner.index');


    }


    public function createKuliner()
    {
        $company = Company::all();
        $categories = CategoryKuliner::all();
        $kecamatan = Kecamatan::all();
        return view('admin.kuliner.create',  compact('kecamatan','categories','company'));
    }

    public function showkuliner($kuliner)
    {
        $hash=new Hashids();
        $kecamatan = Kecamatan::all();
        $kuliner = Kuliner::find($hash->decodeHex($kuliner));

        $latitude = $kuliner->latitude;
        $longitude = $kuliner->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);

        return view('admin.kuliner.show', compact('kuliner','hash','kecamatan', 'weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
    }

    public function showdetailkuliner($id)
    {
        $kuliner = Kuliner::find($id);
        $kecamatan = Kecamatan::all();
        return view('admin.detailkuliner', compact('kuliner','kecamatan'));
    }


    public function rekomendasikuliner($id)
    {
        $kuliner = Kuliner::with('rekomendasikuliner')
            ->whereHas('rekomendasikuliner', function ($query) use ($id) {
                $query->where('kuliner_id', $id);
            })->get();
    
        if ($kuliner->isEmpty()) {
            RekomendasiKuliner::create([
                'kuliner_id' => $id
            ]);
    
            Alert::success('Sukses', 'Post berhasil direkomendasikan');
            Log::info('Data berhasil direkomendasikan: ' . $id);
            return redirect()->route('admin.kuliner.index');
        } else {
            RekomendasiKuliner::where('kuliner_id', $id)->delete();
            Alert::success('Sukses', 'Post batal direkomendasikan');
            Log::info('Data batal direkomendasikan: ' . $id);
            return redirect()->route('admin.kuliner.index');
        }
    }
    





    public function massDestroy(MassDestroyKulinerRequest $request)
    {
        Kuliner::whereIn('id', request('ids'))->delete();
        if (count($kuliner->photos) > 0) {
            foreach ($kuliner->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }

    public function destroy(Request $request,$kuliner)
    {
        $hash=new Hashids();
        $kuliner = Kuliner::find($hash->decodeHex($kuliner));
        $kuliner->delete();
        if (count($kuliner->photos) > 0) {
            foreach ($kuliner->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

  





    public function editkuliner($kuliner)
    {
        $hash=new Hashids();
        $company = Company::with('user.roles')->get();
        $categories = CategoryKuliner::all();
        $kuliner = Kuliner::find($hash->decodeHex($kuliner));
        $kecamatan = Kecamatan::all();
        return view('admin.kuliner.edit', compact( 'kuliner','hash','kecamatan','company'))->with([
            'kuliner' => $kuliner,
            'company' => $company,
            'hash' => $hash,
            'categories' => $categories,
            'kecamatan' => $kecamatan
        ]);
    }

    public function kulinerupdate(Request $request, $kuliner)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash=new Hashids();
        $kuliner = Kuliner::find($hash->decodeHex($kuliner));
        $newKuliner = $kuliner->update($request->all());

        

        if (count($kuliner->photos) > 0) {
            foreach ($kuliner->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $kuliner->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $kuliner->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.kuliner.index');
    }
}