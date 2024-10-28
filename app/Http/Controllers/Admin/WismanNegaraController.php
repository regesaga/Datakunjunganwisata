<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyWismanNegaraRequest;
use App\Http\Requests\StoreWismanNegaraRequest;
use App\Http\Requests\UpdateWismanNegaraRequest;
use App\Models\WismanNegara;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;

class WismanNegaraController extends Controller
{
    //


    public function getAllwismannegara()
    {
        $hash=new Hashids();
        $wismannegara = WismanNegara::all();
        
        return view('account.wisata.wismannegara.index', compact('wismannegara','hash'));
    }



    public function storewismannegara(Request $request)
    {
        $request->validate([
            'wismannegara_name' => 'required|min:5'
        ]);
        WismanNegara::create([
            'wismannegara_name' => $request->wismannegara_name
        ]);
        Alert::toast('Negara Created!', 'success');
        return redirect()->route('account.wisata.wismannegara.index');
    }


    public function createwismannegara()
    {

        return view('account.wisata.wismannegara.create');
    }

    public function editwismannegara($wismannegara)
    {
        $hash=new Hashids();
        $wismannegara = WismanNegara::find($hash->decodeHex($wismannegara));
        return view('account.wisata.wismannegara.edit', compact('wismannegara','hash'))->with([
            'wismannegara' => $wismannegara,
            'hash' => $hash
        ]);
    }

    public function wismannegaraupdate(Request $request, $wismannegara)  
    {
        $hash=new Hashids();
        $wismannegara= WismanNegara::find($hash->decodeHex($wismannegara));
        $newWismanNegara = $wismannegara->update($request->all());


        Alert::toast('WismanNegara Updated!', 'success');
        return redirect()->route('account.wisata.wismannegara.index');
    }

    public function destroy($id)
    {
        $wismannegara = WismanNegara::find($id);
        $wismannegara->delete();
        Alert::toast('WismanNegara Delete!', 'success');
        return redirect()->route('account.wisata.wismannegara.index');
    }

    public function massDestroy(MassDestroyWismanNegaraRequest $request)
    {
        WismanNegara::whereIn('id', request('ids'))->delete();
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
