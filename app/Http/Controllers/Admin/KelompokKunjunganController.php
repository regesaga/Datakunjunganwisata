<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyKelompokKunjunganRequest;
use App\Http\Requests\StoreKelompokKunjunganRequest;
use App\Http\Requests\UpdateKelompokKunjunganRequest;
use App\Models\KelompokKunjungan;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;

class KelompokKunjunganController extends Controller
{
    //


    public function getAllkelompokKunjungan()
    {
        $hash=new Hashids();
        $kelompokKunjungan = KelompokKunjungan::all();

        return view('admin.kelompokkunjungan.index', compact('kelompokKunjungan','hash'));
    }



    public function storekelompokKunjungan(Request $request)
    {
        $request->validate([
            'kelompokkunjungan_name' => 'required|min:4'
        ]);
        KelompokKunjungan::create([
            'kelompokkunjungan_name' => $request->kelompokkunjungan_name
        ]);
        Alert::toast('Kelompok Created!', 'success');
        return redirect()->route('admin.kelompokkunjungan.index');
    }


    public function createkelompokKunjungan()
    {

        return view('admin.kelompokkunjungan.create');
    }

    public function editkelompokKunjungan($kelompokKunjungan)
    {
        $hash=new Hashids();
        $kelompokKunjungan = KelompokKunjungan::find($hash->decodeHex($kelompokKunjungan));
        return view('admin.kelompokKunjungan.edit', compact('kelompokKunjungan','hash'))->with([
            'kelompokKunjungan' => $kelompokKunjungan,
            'hash' => $hash
        ]);
    }

    public function kelompokKunjunganupdate(Request $request, $kelompokKunjungan)  
    {
        $hash=new Hashids();
        $kelompokKunjungan= KelompokKunjungan::find($hash->decodeHex($kelompokKunjungan));
        $newKelompokKunjungan = $kelompokKunjungan->update($request->all());


        Alert::toast('Kelompok di perbaharui!', 'success');
        return redirect()->route('admin.kelompokkunjungan.index');
    }

    public function destroykelompokkunjungan(Request $request,$kelompokKunjungan)
    { 
        $hash=new Hashids();
        $kelompokKunjungan = KelompokKunjungan::find($hash->decodeHex($kelompokKunjungan));
        $kelompokKunjungan->delete();
        Alert::toast('Kelompok Kunjungan diHapus!', 'success');
        return back();
    }

    public function massDestroy(MassDestroyKelompokKunjunganRequest $request)
    {
        KelompokKunjungan::whereIn('id', request('ids'))->delete();
        if (count($kuliner->photos) > 0) {
            foreach ($kuliner->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }



    

}
