<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Models\Company;
use App\Models\CategoryWisata;
use App\Models\Fasilitas;
use App\Models\Kecamatan;
use App\Models\HargaTiket;
use App\Models\RekomendasiWisata;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWisataRequest;
use App\Http\Requests\StoreWisataRequest;
use App\Http\Requests\UpdateWisataRequest;
use App\Models\Weather;
use RealRashid\SweetAlert\Facades\Alert;

use Gate;
use Hashids\Hashids;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class WisataController extends Controller


{
    use MediaUploadingTrait;


    public function getAllWisatas()
    {
        $hash = new Hashids();
        $wisatas = Wisata::all();
        $categories = CategoryWisata::all();
        $fasilitas = Fasilitas::all();

        $hargatiket = HargaTiket::all();
        return view('admin.wisata.index', compact('wisatas', 'hash', 'categories', 'hargatiket', 'fasilitas'));
    }

    public function storeWisata(Request $request)
    {
        $data = $request->all();

        try {

            \DB::beginTransaction();


            $wisata = Wisata::create($request->all());
            $wisata->fasilitas()->sync($request->input('fasilitas', []));

            foreach ($request->input('photos', []) as $file) {
                $wisata->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }


            if ($request->kategori) {
                foreach ($data['kategori'] as $item => $value) {
                    $data2 = array(
                        'wisata_id' => $wisata->id,
                        'kategori' => $data['kategori'][$item],
                        'harga' => $data['harga'][$item],
                    );
                    HargaTiket::create($data2);
                }
            }

            DB::commit();
            Log::info('Data Berhasil Di Input');

            return redirect()->route('admin.wisata.index')->with('status', 'Data Berhasil Di Input');
        } catch (\Throwable $th) {
            DB::rollback();

            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());

            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
        }
    }




    public function createWisata()
    {

        $company = Company::all();
        $categories = CategoryWisata::all();
        $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
        $kecamatan = Kecamatan::all();
        return view('admin.wisata.create',  compact('company', 'categories', 'fasilitas', 'kecamatan'));
    }

    public function showwisata($wisata)
    {
        $hash = new Hashids();
        $wisata = Wisata::find($hash->decodeHex($wisata));

        $latitude = $wisata->latitude;
        $longitude = $wisata->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);

        $hargatiket = $wisata->hargatiket;
        $wisata->load('fasilitas', 'created_by');
        return view('admin.wisata.show', compact('wisata', 'hash', 'hargatiket', 'weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
    }


    // public function showdetailwisata($id)
    //             {
    //                 $encodedId = base64_encode($id);
    //                 $wisata = Wisata::find($id);
    //                 $wisata->load('fasilitas', 'created_by');
    //                 $url = URL::route('admin.detailwisata', $encodedId);
    //                 return view('admin.detailwisata', compact('wisata', 'url'));
    //             }

    public function showdetailwisata($wisata)
    {
        $wisata = Wisata::find($wisata);
        $hargatiket = $wisata->hargatiket;
        $wisata->load('fasilitas', 'created_by');
        return view('admin.detailwisata', compact('wisata', 'hargatiket'));
    }


    public function rekomendasiwisata($id)
    {
        $wisata = Wisata::with('rekomendasiwisata')
            ->whereHas('rekomendasiwisata', function ($query) use ($id) {
                $query->where('wisata_id', $id);
            })->get();

        if ($wisata->isEmpty()) {
            RekomendasiWisata::create([
                'wisata_id' => $id
            ]);

            Alert::success('Sukses', 'Post berhasil direkomendasikan');
            Log::info('Data berhasil direkomendasikan: ' . $id);
            return redirect()->route('admin.wisata.index');
        } else {
            RekomendasiWisata::where('wisata_id', $id)->delete();
            Alert::success('Sukses', 'Post batal direkomendasikan');
            Log::info('Data batal direkomendasikan: ' . $id);
            return redirect()->route('admin.wisata.index');
        }
    }





    public function massDestroy(MassDestroyWisataRequest $request)
    {
        Wisata::whereIn('id', request('ids'))->delete();
        if (count($wisata->photos) > 0) {
            foreach ($wisata->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();
    }

    public function destroy(Request $request, $wisata)
    {
        $hash = new Hashids();
        $wisata = Wisata::find($hash->decodeHex($wisata));
        $wisata->delete();
        if (count($wisata->photos) > 0) {
            foreach ($wisata->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editwisata($wisata)
    {
        $company = Company::with('user.roles')->get();

        $hash = new Hashids();
        $wisata = Wisata::find($hash->decodeHex($wisata));
        $categories = CategoryWisata::all();
        $kecamatan = Kecamatan::all();
        $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
        return view('admin.wisata.edit', compact('wisata', 'company', 'fasilitas', 'categories', 'kecamatan'))->with([
            'wisata' => $wisata,
            'company' => $company,
            'kecamatan' => $kecamatan,
            'categories' => $categories,
            'fasilitas' => $fasilitas,
            'hash' => $hash
        ]);
    }

    public function wisataupdate(Request $request, $wisata)
    {
        if (!$request->active) {
            $request->merge([
                'active' => 0
            ]);
        }
        $hash = new Hashids();
        $wisata = Wisata::with('hargatiket')->find($hash->decodeHex($wisata));
        HargaTiket::where('wisata_id', $wisata->id)->delete();

        $data = $request->all();
        try {

            \DB::beginTransaction();
            $wisata->update($request->all());
            $wisata->fasilitas()->sync($request->input('fasilitas', []));

            if (count($wisata->photos) > 0) {
                foreach ($wisata->photos as $media) {
                    if (!in_array($media->file_name, $request->input('photos', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $wisata->photos->pluck('file_name')->toArray();

            foreach ($request->input('photos', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $wisata->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
                }
            }


            if ($request->kategori && isset($data['kategori'])) {
                foreach ($data['kategori'] as $item => $value) {
                    $data2 = array(
                        'wisata_id' => $wisata->id,
                        'kategori' => $data['kategori'][$item],
                        'harga' => $data['harga'][$item],
                    );
                    HargaTiket::create($data2);
                }
            }


            DB::commit();
            Log::info('Data Berhasil Di Input');

            return redirect()->route('admin.wisata.index')->with('status', 'Data Berhasil Di Input');
        } catch (\Throwable $th) {
            DB::rollback();

            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());

            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
        }
    }
}
