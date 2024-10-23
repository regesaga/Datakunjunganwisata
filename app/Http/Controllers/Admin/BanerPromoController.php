<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BanerPromo;
use App\Http\Requests\MassDestroyBanerPromoRequest;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BanerPromoController extends Controller
{
    public function index()
    {
        $hash=new Hashids();
        $banerpromo = BanerPromo::all();
        return view('admin.banerpromo.index', compact('banerpromo','hash'));
    }


        public function create()
            {
                 return view('admin.banerpromo.create');
            }


            public function store(Request $request)
            {
                $request->validate([
                    'judul' => 'required',
                    'sampul' => 'required|mimes:jpg,jpeg,png',
                ]);
                if(!$request->active){
                    $request->merge([
                        'active' => 0
                    ]);
                }
                $sampul = time() .'-' .$request->sampul->getClientOriginalName();
                $request->sampul->move('upload/banerpromo', $sampul);
        
                BanerPromo::create([
                    'sampul' => $sampul,
                    'judul' => $request->judul,
                    'active' => $request->active,
                    'created_by_id' => Auth::user()->id
                ]);
        
                Alert::success('Sukses', 'Data berhasil ditambahkan');
                return redirect()->route('admin.banerpromo.index');
            }

            
 
    public function show($banerpromo)
    {
                    $hash=new Hashids();
                    $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                    return view('admin.banerpromo.show', compact('banerpromo','hash'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($banerpromo)
    {
        $hash=new Hashids();
        $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
        return view('admin.banerpromo.edit', compact( 'banerpromo','hash'))->with([
            'banerpromo' => $banerpromo,
            'hash' => $hash
        ]);
    }

 
    public function update(Request $request, $id)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash = new Hashids();
       
    
        $banerpromo = BanerPromo::findOrFail($hash->decodeHex($id));
    
        $data = $request->all();
    
        if ($request->hasFile('sampul')) {
            $request->validate([
                'sampul' => 'mimes:jpg,jpeg,png',
            ]);
    
            $sampul = time() . '-' . $request->sampul->getClientOriginalName();
            $request->sampul->move('upload/banerpromo', $sampul);
    
            File::delete('upload/banerpromo/' . $banerpromo->sampul);
            $data['sampul'] = $sampul;
        }
    
        $banerpromo->update($data);
    
        Alert::success('Sukses', 'Data berhasil diubah');
        return redirect()->route('admin.banerpromo.index');
    }
    

 
    

        public function destroy(Request $request,$banerpromo)
                {
                    $hash=new Hashids();
                    $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                    File::delete('upload/banerpromo/' . $banerpromo->sampul);
                    $banerpromo->delete();
            
            
                    return back();
                }

                public function massDestroy(MassDestroyBanerPromoRequest $request)
                {
                    BanerPromo::whereIn('id', request('ids'))->delete();
            
                    return back();
                }

  
}

