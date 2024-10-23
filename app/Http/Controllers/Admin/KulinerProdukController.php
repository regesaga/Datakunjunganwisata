<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert; 
use App\Models\KulinerProduk;
use App\Models\Kuliner;
use App\Models\Company;
use App\Models\Kecamatan;
use Gate;
use Hashids\Hashids;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyKulinerProdukRequest;
use App\Http\Requests\StoreKulinerRequest;
use App\Http\Requests\UpdateKulinerRequest;
use Symfony\Component\HttpFoundation\Response;

class KulinerProdukController extends Controller
{
    use MediaUploadingTrait;


    public function getAllKulinerproduk()
    {
        $hash=new Hashids();
        $kulinerproduks = KulinerProduk::all();
        $kuliner = Kuliner::all();
        return view('admin.kulinerproduk.index', compact('kuliner','kulinerproduks','hash',));
    }

    public function storeKulinerproduk(Request $request)
{
    $data = $request->all();

        try {

            \DB::beginTransaction();


            $kulinerproduk = KulinerProduk::create($request->all());

            foreach ($request->input('photos', []) as $file) {
                $kulinerproduk->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
     

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('admin.kulinerproduk.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            


    public function createKulinerproduk()
    {
        
        $kuliner = Kuliner::all();
        
        return view('admin.kulinerproduk.create',  compact('kuliner'));
    }

    public function showkulinerproduk($kulinerproduk)
    {
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        return view('admin.kulinerproduk.show', compact('kulinerproduk','hash'));
    }


    public function showdetailkulinerproduk($id)
    {
        $kulinerproduk = KulinerProduk::find($id);
        return view('admin.detailkulinerproduk', compact('kulinerproduk'));
    }

   
    public function massDestroy(MassDestroyKulinerProdukRequest $request)
    {
        KulinerProduk::whereIn('id', request('ids'))->delete();
        if (count($kulinerproduk->photos) > 0) {
            foreach ($kulinerproduk->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }

    public function destroy(Request $request,$kulinerproduk)
    {
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        $kulinerproduk->delete();
        if (count($kulinerproduk->photos) > 0) {
            foreach ($kulinerproduk->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editkulinerproduk($kulinerproduk)
    {
        $kuliner = Kuliner::all();
        
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        return view('admin.kulinerproduk.edit', compact( 'kulinerproduk','kuliner'))->with([
            'kulinerproduk' => $kulinerproduk,
            'kuliner' => $kuliner,
            'hash' => $hash
        ]);
    }
  
    public function kulinerprodukupdate(Request $request, $kulinerproduk)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $kulinerproduk->update($request->all());

        if (count($kulinerproduk->photos) > 0) {
            foreach ($kulinerproduk->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $kulinerproduk->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $kulinerproduk->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('admin.kulinerproduk.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
}
