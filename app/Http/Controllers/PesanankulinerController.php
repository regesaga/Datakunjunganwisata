<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Events\KulinerViewEvent;
use App\Models\Kuliner;
use App\Models\Wisatawan;
use App\Models\Company;
use App\Models\User;
use App\Models\KulinerProduk;
use App\Models\Pesankuliner;
use App\Models\PesananKulinerDetail;
use App\Models\Fasilitas;
use App\Models\CategoryKuliner;
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



class PesanankulinerController extends Controller
{
    
    public function index()
    {
        $hash = new Hashids();
        $pesankuliner = Pesankuliner::all();
        return view('admin.pesanankuliner.index', compact('pesankuliner', 'hash'));
    }
    

    public function pesanankuliner($kuliner_id)
    {
        $hash = new Hashids();
        $kuliner_id = $hash->decodeHex($kuliner_id);
        $kuliner= Kuliner::find($kuliner_id);
        $pesankuliner = Pesankuliner::where('kuliner_id', $kuliner->id)->get();
        return view('admin.pesanankuliner.bykuliner', compact('pesankuliner','hash'));
    }

    public function detailpesanankuliner($id)
    {
        $hash = new Hashids();
        $decodedId = $hash->decodeHex($id);
        $detailkuliner = PesananKulinerDetail::where('pesankuliner_id', $decodedId)->get();
    
        if ($detailkuliner->isEmpty()) {
            return redirect()->back()->with('error', 'Data detail kuliner tidak ditemukan.');
        }
    
        return view('admin.pesanankuliner.detail', compact('detailkuliner', 'hash'));
    }

    public function pesanankulinerwisatawan()
    {
        $hash = new Hashids();
        $wisatawan = Auth::guard('wisatawans')->user();
        $pesankuliner = Pesankuliner::where('wisatawan_id', $wisatawan->id)->orderBy('created_at', 'desc')->get();
        return view('wisatawan.pesanankuliner', compact('pesankuliner', 'hash'));
    }

    public function detailpesanan($id)
    {
        $hash = new Hashids();
        $decodedId = $hash->decodeHex($id);
        $detailkuliner = PesananKulinerDetail::where('pesankuliner_id', $decodedId)->get();
    
        if ($detailkuliner->isEmpty()) {
            return redirect()->back()->with('error', 'Data detail kuliner tidak ditemukan.');
        }
    
        return view('wisatawan.detailpesanankuliner', compact('detailkuliner', 'hash'));
    }


   

    
   
    

   
}