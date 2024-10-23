<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Http\Requests\MassDestroySupportRequest;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Hashids\Hashids;

class SupportController extends Controller
{
    public function index()
    {
        $hash=new Hashids();
        $search = '';
        if (request()->search) {
            $support = Support::select('id', 'sampul', 'judul')->where('judul', 'LIKE', '%' . request()->search . '%')->latest()->paginate(10);
            $search = request()->search;

            if (count($support) == 0) {
                request()->session()->flash('search', '
                    <div class="alert alert-success mt-4" role="alert">
                        Data yang anda cari tidak ada
                    </div>
                ');
            }
        } else {
            $support = Support::select('id', 'sampul', 'judul')->latest()->paginate(10);
        }

        return view('admin.support.index', compact('support', 'search','hash'));
    }



        public function create()
            {
                 return view('admin.support.create');
            }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'sampul' => 'required|mimes:jpg,jpeg,png',
        ]);

        $sampul = time() . '-' . $request->sampul->getClientOriginalName();
        $request->sampul->move('upload/support', $sampul);

        Support::create([
            'sampul' => $sampul,
            'judul' => $request->judul,
        ]);

        Alert::success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('admin.support.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($support)
    {
                    $hash=new Hashids();
                    $support = Support::find($hash->decodeHex($support));
                    return view('admin.support.show', compact('support','hash'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($support)
    {
        $hash=new Hashids();
        $support = Support::find($hash->decodeHex($support));
        return view('admin.support.edit', compact( 'support','hash'))->with([
            'support' => $support,
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
        
        $support = Support::select('sampul', 'id')->whereId($hash->decodeHex($id))->first();
        if ($request->sampul) {
            File::delete('upload/support/' . $support->sampul);

            $sampul = time() . '-' . $request->sampul->getClientOriginalName();
            $request->sampul->move('upload/support', $sampul);

            $data['sampul'] = $sampul;
        }

        $support->update($data);

        Alert::success('Sukses', 'Data berhasil diubah');
        return redirect()->route('admin.support.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     

        public function destroy(Request $request,$support)
                {
                    $hash=new Hashids();
                    $support = Support::find($hash->decodeHex($support));
                    File::delete('upload/support/' . $support->sampul);
                    $support->delete();
            
            
                    return back();
                }

                public function massDestroy(MassDestroySupportRequest $request)
                {
                    Support::whereIn('id', request('ids'))->delete();
            
                    return back();
                }


  
}

