<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Events\WisataViewEvent;
use App\Models\Akomodasi;
use App\Models\Wisatawan;
use App\Models\Company;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Reserv;
use App\Models\Reservation;
use App\Models\Fasilitas;
use App\Models\CategoryAkomodasi;
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



class ReservationController extends Controller
{
    
    public function index()
    {
        $hash = new Hashids();
        $reserv = Reserv::all();
        return view('admin.reserv.index', compact('reserv', 'hash'));
    }
    

    public function reservakomodasi($id)
    {
        $hash = new Hashids();
        $akomodasiId = $hash->decodeHex($id);
        $akomodasi= Akomodasi::find($akomodasiId);
        $reserv = Reserv::where('akomodasi_id', $akomodasi)->get();
        return view('admin.reserv.byakomodasi', compact('reserv','hash'));
    }

    public function reservationdetail($id)
    {
        $hash = new Hashids();
        $decodedId = $hash->decodeHex($id);
        $reservation = Reservation::where('reserv_id', $decodedId)->get();
    
        if ($reservation->isEmpty()) {
            return redirect()->back()->with('error', 'Data detail booking tidak ditemukan.');
        }
    
        return view('admin.reserv.detail', compact('reservation', 'hash'));
    }

    public function reservwisatawan()
    {
        $hash = new Hashids();
        $wisatawan = Auth::guard('wisatawans')->user();
        $reserv = Reserv::where('wisatawan_id', $wisatawan->id)->orderBy('created_at', 'desc')->get();
        return view('wisatawan.reserv', compact('reserv', 'hash'));
    }

    public function reservation($id)
    {
        $hash = new Hashids();
        $decodedId = $hash->decodeHex($id);
        $reservation = Reservation::where('reserv_id', $decodedId)->get();
    
        if ($reservation->isEmpty()) {
            return redirect()->back()->with('error', 'Data detail tiket tidak ditemukan.');
        }
    
        return view('wisatawan.reservation', compact('reservation', 'hash'));
    }



    
   
    

   
}