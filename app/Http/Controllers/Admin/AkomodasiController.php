<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert; 
use App\Models\Akomodasi;
use App\Models\CategoryAkomodasi;
use App\Models\Company;
use App\Models\Fasilitas;
use App\Models\Kecamatan;
use App\Models\RekomendasiAkomodasi;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAkomodasiRequest;
use App\Http\Requests\StoreAkomodasiRequest;
use App\Http\Requests\UpdateAkomodasiRequest;
use App\Models\Weather;
use Gate;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response;
class AkomodasiController extends Controller
{
    //
    use MediaUploadingTrait;


    public function getAllAkomodasi()
    {
        $hash=new Hashids();
        $akomodasi = Akomodasi::all();
        $categories = CategoryAkomodasi::all();
        $fasilitas = Fasilitas::all();
        
        return view('admin.akomodasi.index', compact('akomodasi','hash', 'categories','fasilitas'));
    }

    public function storeAkomodasi(Request $request)
            {
              
                        $akomodasi = Akomodasi::create($request->all());
                        $akomodasi->fasilitas()->sync($request->input('fasilitas', []));

                        foreach ($request->input('photos', []) as $file) {
                            $akomodasi->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
                        }
                       
                        return redirect()->route('admin.akomodasi.index');
                        Log::info('Data Berhasil Di Input');
                        
                        
            }

            public function createAkomodasi()
                {
                    $company = Company::all();
                    $categories = CategoryAkomodasi::all();
                    $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
                    
                    $kecamatan = Kecamatan::all();
                    return view('admin.akomodasi.create',  compact( 'categories','fasilitas','kecamatan', 'company'));
                }       
                
                public function showakomodasi($akomodasi)
                {
                    $hash=new Hashids();
                    $akomodasi = Akomodasi::find($hash->decodeHex($akomodasi));
                   
                    $latitude = $akomodasi->latitude;
                    $longitude = $akomodasi->longitude;
                    $weatherData = $this->getWeatherData($latitude, $longitude);
                    $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
                    $imageName = $this->chooseWeatherImage($weatherCode);
                    $temperatureKelvin = $weatherData['main']['temp'];
                    $temperatureCelsius = $temperatureKelvin - 273.15;
                    $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
                    $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
                    $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
                    $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);
                    $akomodasi->load('fasilitas', 'created_by');
                    return view('admin.akomodasi.show', compact('akomodasi','hash', 'weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
                }      

                public function showdetailakomodasi($id)
                {
                    $akomodasi = Akomodasi::find($id);
                    $akomodasi->load('fasilitas', 'created_by');
                    return view('admin.detailakomodasi', compact('akomodasi'));
                }



                public function massDestroy(MassDestroyAkomodasiRequest $request)
                {
                    Akomodasi::whereIn('id', request('ids'))->delete();
                    if (count($akomodasi->photos) > 0) {
                        foreach ($akomodasi->photos as $media) {
                            if (!in_array($media->file_name, $request->input('photos', []))) {
                                $media->delete();
                            }
                        }
                    }
                    return back();
            
                }
            
                public function destroy(Request $request,$akomodasi)
                {
                    $hash=new Hashids();
                    $akomodasi = Akomodasi::find($hash->decodeHex($akomodasi));
                    $akomodasi->delete();
                    if (count($akomodasi->photos) > 0) {
                        foreach ($akomodasi->photos as $media) {
                            if (!in_array($media->file_name, $request->input('photos', []))) {
                                $media->delete();
                            }
                        }
                    }
            
                    return back();
                }
            
                public function editakomodasi($akomodasi)
                {
                    
                    $hash=new Hashids();
                    $akomodasi = Akomodasi::find($hash->decodeHex($akomodasi));
                    $categories = CategoryAkomodasi::all();
                    $company = Company::with('user.roles')->get();
                    $kecamatan = Kecamatan::all();
                    $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
                    return view('admin.akomodasi.edit', compact( 'akomodasi','fasilitas', 'categories','kecamatan','company'))->with([
                        'akomodasi' => $akomodasi,
                        'company' => $company,
                        'kecamatan' => $kecamatan,
                        'categories' => $categories,
                        'fasilitas' => $fasilitas,
                        'hash' => $hash
                    ]);
                }


                public function akomodasiupdate(Request $request, $akomodasi)
                {
                    if(!$request->active){
                        $request->merge([
                            'active' => 0
                        ]);
                    }
                    $hash=new Hashids();
                    $akomodasi = Akomodasi::find($hash->decodeHex($akomodasi));
                    $newAkomodasi = $akomodasi->update($request->all());
            
                    
            
                    if (count($akomodasi->photos) > 0) {
                        foreach ($akomodasi->photos as $media) {
                            if (!in_array($media->file_name, $request->input('photos', []))) {
                                $media->delete();
                            }
                        }
                    }
            
                    $media = $akomodasi->photos->pluck('file_name')->toArray();
            
                    foreach ($request->input('photos', []) as $file) {
                        if (count($media) === 0 || !in_array($file, $media)) {
                            $akomodasi->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
                        }
                    }
            
                    return redirect()->route('admin.akomodasi.index');
                }
              


                public function rekomendasiakomodasi($id)
    {
        $akomodasi = Akomodasi::with('rekomendasiakomodasi')
            ->whereHas('rekomendasiakomodasi', function ($query) use ($id) {
                $query->where('akomodasi_id', $id);
            })->get();
    
        if ($akomodasi->isEmpty()) {
            RekomendasiAkomodasi::create([
                'akomodasi_id' => $id
            ]);
    
            Alert::success('Sukses', 'Post berhasil direkomendasikan');
            Log::info('Data berhasil direkomendasikan: ' . $id);
            return redirect()->route('admin.akomodasi.index');
        } else {
            RekomendasiAkomodasi::where('akomodasi_id', $id)->delete();
            Alert::success('Sukses', 'Post batal direkomendasikan');
            Log::info('Data batal direkomendasikan: ' . $id);
            return redirect()->route('admin.akomodasi.index');
        }
    }

}
