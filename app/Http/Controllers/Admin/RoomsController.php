<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\Akomodasi;
use App\Models\CategoryRooms;
use App\Models\Fasilitas;
use  Storage;
use  Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRoomsRequest;
use App\Http\Requests\StoreRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;
use RealRashid\SweetAlert\Facades\Alert; 

use Gate;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response;

class RoomsController extends Controller
{
    use MediaUploadingTrait;


    public function getAllRoom()
    {
        $hash=new Hashids();
        $rooms = Rooms::all();
        $categories = CategoryRooms::all();
        $fasilitas = Fasilitas::all();
        
        return view('admin.room.index', compact('rooms','hash', 'categories','fasilitas'));
    }

    public function storeRoom(Request $request)
{
    $data = $request->all();

        try {

            \DB::beginTransaction();


            $room = Rooms::create($request->all());
            $room->fasilitas()->sync($request->input('fasilitas', []));

            foreach ($request->input('photos', []) as $file) {
                $room->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
     

          

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('admin.room.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            



    public function createRoom()
    {
        
        $akomodasi = Akomodasi::all();
        $categories = CategoryRooms::all();
        $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
        
        return view('admin.room.create',  compact('akomodasi', 'categories','fasilitas'));
    }

    public function showroom($room)
    {
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        $room->load('fasilitas', 'created_by');
        return view('admin.room.show', compact('room','hash'));
    }


    public function showdetailroom($id)
    {
        $room = Rooms::find($id);
        $room->load('fasilitas', 'created_by');
        return view('admin.detailroom', compact('room'));
    }

   
    public function massDestroy(MassDestroyRoomsRequest $request)
    {
        Rooms::whereIn('id', request('ids'))->delete();
        if (count($room->photos) > 0) {
            foreach ($room->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }

    public function destroy(Request $request,$room)
    {
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        $room->delete();
        if (count($room->photos) > 0) {
            foreach ($room->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editroom($room)
    {
        $akomodasi = Akomodasi::all();
        
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        $categories = CategoryRooms::all();
        $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
        return view('admin.room.edit', compact( 'room','akomodasi','fasilitas', 'categories'))->with([
            'room' => $room,
            'akomodasi' => $akomodasi,
            'categories' => $categories,
            'fasilitas' => $fasilitas,
            'hash' => $hash
        ]);
    }
  
    public function roomupdate(Request $request, $room)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $room->update($request->all());
            $room->fasilitas()->sync($request->input('fasilitas', []));

        if (count($room->photos) > 0) {
            foreach ($room->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $room->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $room->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('admin.room.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
}
