<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBanerRequest;
use App\Models\Baner;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Hashids\Hashids;

class BanerController extends Controller
{
    public function index()
    {
      $hash=new Hashids();
        $banner = Baner::all();
        return view('admin.baners.index', compact('banner','hash'));

    }



        public function create()
            {
                 return view('admin.baners.create');
            }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'sampul' => 'required|mimes:jpg,jpeg,png',
        ]);

        $sampul = time() . '-' . $request->sampul->getClientOriginalName();
        $request->sampul->move('upload/banner', $sampul);

        Baner::create([
            'sampul' => $sampul,
            'judul' => $request->judul,
        ]);

        Alert::success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('admin.baners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($banner)
    {
                    $hash=new Hashids();
                    $banner = Baner::find($hash->decodeHex($banner));
                    return view('admin.baners.show', compact('banner','hash'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($banner)
    {
        $hash=new Hashids();
        $banner = Baner::find($hash->decodeHex($banner));
        return view('admin.baners.edit', compact( 'banner','hash'))->with([
            'banner' => $banner,
            'hash' => $hash
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hash=new Hashids();
        $request->validate([
            'judul' => 'required',
            'sampul' => 'mimes:jpg,jpeg,png',
        ]);

        $data = [
            'judul' => $request->judul,
        ];
        
        $banner = Baner::select('sampul', 'id')->whereId($hash->decodeHex($id))->first();
        if ($request->sampul) {
            File::delete('upload/banner/' . $banner->sampul);

            $sampul = time() . '-' . $request->sampul->getClientOriginalName();
            $request->sampul->move('upload/banner', $sampul);

            $data['sampul'] = $sampul;
        }

        $banner->update($data);

        Alert::success('Sukses', 'Data berhasil diubah');
        return redirect()->route('admin.baners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

        public function destroy(Request $request,$banner)
                {
                    $hash=new Hashids();
                    $banner = Baner::find($hash->decodeHex($banner));
                    File::delete('upload/banner/' . $banner->sampul);
                    $banner->delete();
            
            
                    return back();
                }

                public function massDestroy(MassDestroyBanerRequest $request)
                {
                    Baner::whereIn('id', request('ids'))->delete();
            
                    return back();
                }

  
}

