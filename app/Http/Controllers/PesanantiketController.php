<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Events\WisataViewEvent;
use App\Models\Wisata;
use App\Models\Wisatawan;
use App\Models\Company;
use App\Models\User;
use App\Models\HargaTiket;
use App\Models\Pesantiket;
use App\Models\PesananTiketDetail;
use App\Models\Fasilitas;
use App\Models\CategoryWisata;
use App\Models\Baner;
use Hashids\Hashids;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;



class PesanantiketController extends Controller
{
    
    public function index()
    {
        $hash = new Hashids();
        $pesantiket = Pesantiket::all();
        return view('admin.pesanantiket.index', compact('pesantiket', 'hash'));
    }
    

    public function pesananwisata($id)
    {
        $hash = new Hashids();
        $wisataId = $hash->decodeHex($id);
        $wisata= Wisata::find($wisataId);
        $pesantiket = Pesantiket::where('wisata_id', $wisata->id)->get();
        return view('admin.pesanantiket.bywisata', compact('pesantiket','hash'));
    }

    public function detailtiketwisata($id)
    {
        $hash = new Hashids();
        $decodedId = $hash->decodeHex($id);
        $detailtiket = PesananTiketDetail::where('pesantiket_id', $decodedId)->get();
    
        if ($detailtiket->isEmpty()) {
            return redirect()->back()->with('error', 'Data detail tiket tidak ditemukan.');
        }
    
        return view('admin.pesanantiket.detail', compact('detailtiket', 'hash'));
    }

    public function pesanantiketwisatawan()
    {
        $hash = new Hashids();
        $wisatawan = Auth::guard('wisatawans')->user();
        $pesantiket = Pesantiket::where('wisatawan_id', $wisatawan->id)->orderBy('created_at', 'desc')->get();
        return view('wisatawan.pesanan', compact('pesantiket', 'hash'));
    }

    public function detailpesanan($id)
    {
        $hash = new Hashids();
        $decodedId = $hash->decodeHex($id);
        $detailtiket = PesananTiketDetail::where('pesantiket_id', $decodedId)->get();
    
        if ($detailtiket->isEmpty()) {
            return redirect()->back()->with('error', 'Data detail tiket tidak ditemukan.');
        }
    
        return view('wisatawan.detailpesanan', compact('detailtiket', 'hash'));
    }

    



    
   
    

   
}