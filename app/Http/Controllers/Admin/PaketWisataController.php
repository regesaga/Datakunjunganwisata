<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\PaketWisata;
use App\Models\Company;
use App\Models\Fasilitas;
use App\Models\Htpaketwisata;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPaketWisataRequest;
use Gate;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response;

class PaketWisataController extends Controller
{
    use MediaUploadingTrait;

    public function getAllPaketwisata()
    {
        $hash=new Hashids();
        $paketwisata = PaketWisata::all();
        
        $htpaketwisata = Htpaketwisata::all();
        return view('admin.paketwisata.index', compact('paketwisata','hash','htpaketwisata'));
    }

    public function storePaketwisata(Request $request)
        {
            $data = $request->all();

                try {

                    \DB::beginTransaction();
                    $paketwisata = PaketWisata::create($request->all());

                    foreach ($request->input('photos', []) as $file) {
                        $paketwisata->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
                    }
                    if ($request->jenis) {
                        foreach ($data['jenis'] as $item => $value) {
                            $data2 = array(
                                'paketwisata_id' => $paketwisata->id,
                                'jenis' => $data['jenis'][$item],
                                'harga' => $data['harga'][$item],
                            );
                            Htpaketwisata::create($data2);
                        }
                    }

                    DB::commit();
                    Log::info('Data Berhasil Di Input');
                    
                    return redirect()->route('admin.paketwisata.index')->with('status', 'Data Berhasil Di Input');
                    } catch (\Throwable $th) {
                    DB::rollback();
                    
                    Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
                    
                    return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
                    }
                    }
                    public function createPaketWisata()
                    {
                        
                        $company = Company::all();
                        return view('admin.paketwisata.create',  compact('company'));
                    }
                
                    public function showPaketWisata($paketwisata)
                    {
                        $hash=new Hashids();
                        $paketwisata = PaketWisata::find($hash->decodeHex($paketwisata));
                        $htpaketwisata = $paketwisata->htpaketwisata;
                        return view('admin.paketwisata.show', compact('paketwisata','hash','htpaketwisata'));
                    }
                
                
                
                
                
                
                    public function massDestroy(MassDestroyPaketWisataRequest $request)
                    {
                        PaketWisata::whereIn('id', request('ids'))->delete();
                        if (count($paketwisata->photos) > 0) {
                            foreach ($paketwisata->photos as $media) {
                                if (!in_array($media->file_name, $request->input('photos', []))) {
                                    $media->delete();
                                }
                            }
                        }
                        return back();
                
                    }
                
                    public function destroy(Request $request,$paketwisata)
                    {
                        $hash=new Hashids();
                        $paketwisata = PaketWisata::find($hash->decodeHex($paketwisata));
                        $paketwisata->delete();
                        if (count($paketwisata->photos) > 0) {
                            foreach ($paketwisata->photos as $media) {
                                if (!in_array($media->file_name, $request->input('photos', []))) {
                                    $media->delete();
                                }
                            }
                        }
                
                        return back();
                    }
                
                    public function editPaketWisata($paketwisata)
                    {
                        $company = Company::all();
                        
                        $hash=new Hashids();
                        $paketwisata = PaketWisata::find($hash->decodeHex($paketwisata));
                        return view('admin.paketwisata.edit', compact( 'paketwisata','company'))->with([
                            'paketwisata' => $paketwisata,
                            'company' => $company,
                            'hash' => $hash
                        ]);
                    }
                  
                    public function PaketWisataupdate(Request $request, $paketwisata)
                    {
                        if(!$request->active){
                            $request->merge([
                                'active' => 0
                            ]);
                        }
                        $hash=new Hashids();
                        $paketwisata = PaketWisata::with('htpaketwisata')->find($hash->decodeHex($paketwisata));
                        Htpaketwisata::where('paketwisata_id', $paketwisata->id)->delete();
                        
                        $data = $request->all();
                        try {
                
                            \DB::beginTransaction();
                            $paketwisata->update($request->all());

                        if (count($paketwisata->photos) > 0) {
                            foreach ($paketwisata->photos as $media) {
                                if (!in_array($media->file_name, $request->input('photos', []))) {
                                    $media->delete();
                                }
                            }
                        }
                
                        $media = $paketwisata->photos->pluck('file_name')->toArray();
                
                        foreach ($request->input('photos', []) as $file) {
                            if (count($media) === 0 || !in_array($file, $media)) {
                                $paketwisata->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
                            }
                        }
                
                           
                        if ($request->jenis && isset($data['jenis'])) {
                            foreach ($data['jenis'] as $item => $value) {
                                $data2 = array(
                                    'paketwisata_id' => $paketwisata->id,
                                    'jenis' => $data['jenis'][$item],
                                    'harga' => $data['harga'][$item],
                                );
                                Htpaketwisata::create($data2);
                            }
                        }
                        
                
                            DB::commit();
                            Log::info('Data Berhasil Di Input');
                            
                            return redirect()->route('admin.paketwisata.index')->with('status', 'Data Berhasil Di Input');
                            } catch (\Throwable $th) {
                            DB::rollback();
                            
                            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
                            
                            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
                            }
                            }


}