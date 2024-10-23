<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySektorEkrafRequest;
use App\Http\Requests\StoreSektorEkrafRequest;
use App\Http\Requests\UpdateSektorEkrafRequest;
use App\Models\CategorySektorEkraf;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;

class SektorEkrafController extends Controller
{
   
public function getAllsektorekrafs()
{
    $hash=new Hashids();
    $sektorekraf = SektorEkraf::all();

    return view('admin.sektorekraf.index', compact('sektorekraf','hash'));
}



public function storesektorekraf(Request $request)
{
    $request->validate([
        'sektor_name' => 'required|min:5'
    ]);
    SektorEkraf::create([
        'sektor_name' => $request->sektor_name
    ]);
    Alert::toast('Category Created!', 'success');
    return redirect()->route('admin.sektorekraf.index');
}


public function createsektorekraf()
{

    return view('admin.sektorekraf.create');
}

public function editsektorekraf($sektorekraf)
{
    $hash=new Hashids();
    $sektorekraf = SektorEkraf::find($hash->decodeHex($sektorekraf));
    return view('admin.sektorekraf.edit', compact('sektorekraf','hash'));
}

public function sektorekrafupdate(Request $request, $sektorekraf)
{
    $hash=new Hashids();

    $request->validate([
        'sektor_name' => 'required|min:5'
    ]);
    $sektorekraf = SektorEkraf::find($hash->decodeHex($sektorekraf));
    $sektorekraf->update([
        'sektor_name' => $request->sektor_name
    ]);
    Alert::toast('Category Updated!', 'success');
    return redirect()->route('admin.sektorekraf.index');
}

public function destroy($id)
{
    $sektorekraf = SektorEkraf::find($id);
    $sektorekraf->delete();
    Alert::toast('Category Delete!', 'success');
    return redirect()->route('admin.sektorekraf.index');
}
}