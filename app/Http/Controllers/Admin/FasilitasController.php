<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyFasilitasRequest;
use App\Http\Requests\StoreFasilitasRequest;
use App\Http\Requests\UpdateFasilitasRequest;
use App\Models\Fasilitas;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;

class FasilitasController extends Controller
{
    //


    public function getAllfasilitas()
    {
        $hash=new Hashids();
        $fasilitas = Fasilitas::all();

        return view('admin.fasilitas.index', compact('fasilitas','hash'));
    }



    public function storefasilitas(Request $request)
    {
        $request->validate([
            'fasilitas_name' => 'required|min:5'
        ]);
        Fasilitas::create([
            'fasilitas_name' => $request->fasilitas_name
        ]);
        Alert::toast('FAsilitas Created!', 'success');
        return redirect()->route('admin.fasilitas.index');
    }


    public function createfasilitas()
    {

        return view('admin.fasilitas.create');
    }

    public function editfasilitas($fasilitas)
    {
        $hash=new Hashids();
        $fasilitas = Fasilitas::find($hash->decodeHex($fasilitas));
        return view('admin.fasilitas.edit', compact('fasilitas','hash'))->with([
            'fasilitas' => $fasilitas,
            'hash' => $hash
        ]);
    }

    public function fasilitasupdate(Request $request, $fasilitas)  
    {
        $hash=new Hashids();
        $fasilitas= Fasilitas::find($hash->decodeHex($fasilitas));
        $newFasilitas = $fasilitas->update($request->all());


        Alert::toast('Fasilitas Updated!', 'success');
        return redirect()->route('admin.fasilitas.index');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::find($id);
        $fasilitas->delete();
        Alert::toast('Fasilitas Delete!', 'success');
        return redirect()->route('admin.fasilitas.index');
    }

    public function massDestroy(MassDestroyFasilitasRequest $request)
    {
        Fasilitas::whereIn('id', request('ids'))->delete();
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
