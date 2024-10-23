<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\MassDestroyTagRequest;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Hashids\Hashids;


class TagController extends Controller
{
    public function index()
    {
        $hash=new Hashids();
        $search = '';
        if (request()->search) {
            $tag = Tag::select('id', 'nama', 'slug')->where('nama', 'LIKE', '%' . request()->search . '%')->latest()->paginate(10);
            $search = request()->search;

            if (count($tag) == 0) {
                request()->session()->flash('search', '
                    <div class="alert alert-success mt-4" role="alert">
                        Data yang anda cari tidak ada
                    </div>
                ');
            }
        } else {
            $tag = Tag::select('id', 'slug', 'nama')->latest()->paginate(10);
        }

        return view('admin.tag.index', compact('tag', 'search','hash'));
    }



        public function create()
            {
                 return view('admin.tag.create');
            }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        Tag::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama, '-')
        ]);

        $request->session()->flash('sukses', '
            <div class="alert alert-success" role="alert">
                Data berhasil ditambahkan
            </div>
        ');
        return redirect()->route('admin.tag.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tag)
    {
                    $hash=new Hashids();
                    $tag = Tag::find($hash->decodeHex($tag));
                    return view('admin.tag.show', compact('tag','hash'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tag)
    {
        $hash=new Hashids();
        $tag = Tag::find($hash->decodeHex($tag));
        return view('admin.tag.edit', compact( 'tag','hash'))->with([
            'tag' => $tag,
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
            'nama' => 'required',
        ]);

        Tag::whereId($hash->decodeHex($id))->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama, '-')
        ]);

        $request->session()->flash('sukses', '
            <div class="alert alert-success" role="alert">
                Data berhasil diubah
            </div>
        ');
        return redirect()->route('admin.tag.index');
    }


  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

        public function destroy(Request $request,$tag)
                {
                    $hash=new Hashids();
                    $tag = Tag::find($hash->decodeHex($tag));
                    File::delete('upload/tag/' . $tag->nama);
                    $tag->delete();
            
            
                    return back();
                }

                public function massDestroy(MassDestroyTagRequest $request)
                {
                    Tag::whereIn('id', request('ids'))->delete();
            
                    return back();
                }

}
