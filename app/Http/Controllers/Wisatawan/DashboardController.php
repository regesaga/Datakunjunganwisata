<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Weather;
use App\Models\HargaTiket;
use App\Models\Kuliner;
use App\Models\KulinerProduk;
use App\Models\Pesankuliner;
use App\Models\Reserv;
use App\Models\Pesantiket;
use App\Models\Wisata;
use App\Models\Wisatawan;
use App\Models\PesananTiketDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $wisatawan = Auth::guard('wisatawans')->user();
    $jumlah_dipakai = Pesantiket::where('wisatawan_id', $wisatawan->id)->where('statuspemakaian', '11')->count();
    $jumlah_belumdibayar = Pesantiket::where('wisatawan_id', $wisatawan->id)->where('payment_status', '00')->count();
    $jumlah_belumdipakai = Pesantiket::where('wisatawan_id', $wisatawan->id)->where('statuspemakaian', '00')->count();
    $jumlah_kadaluarsa = Pesantiket::where('wisatawan_id', $wisatawan->id)->where('payment_status', '22')->count();
    
    $jumlah_selesai = Pesankuliner::where('wisatawan_id', $wisatawan->id)->where('statuspesanan', '11')->count();
    $jumlah_kulinerbelumdibayar = Pesankuliner::where('wisatawan_id', $wisatawan->id)->where('payment_status', '00')->count();
    $jumlah_kulinerkadaluarsa = Pesankuliner::where('wisatawan_id', $wisatawan->id)->where('payment_status', '22')->count();

    $jumlah_selesaiakomodasi = Reserv::where('wisatawan_id', $wisatawan->id)->where('statuspemakaian', '11')->count();
    $jumlah_akomodasibelumdibayar = Reserv::where('wisatawan_id', $wisatawan->id)->where('payment_status', '00')->count();
    $jumlah_akomodasikadaluarsa = Reserv::where('wisatawan_id', $wisatawan->id)->where('payment_status', '22')->count();
    $pesantiket = Pesantiket::where('wisatawan_id', $wisatawan->id)
    ->where('payment_status', '00')
    ->where('statuspemakaian', '00')
    ->orderBy('created_at', 'desc')
    ->get();
    $canceled = Pesantiket::where('wisatawan_id', $wisatawan->id)
    ->where(function ($query) {
        $query->where('payment_status', '22')
              ->orWhere('payment_status', '33');
    })
    ->orderBy('created_at', 'desc')
    ->get();

    $pesankuliner = Pesankuliner::where('wisatawan_id', $wisatawan->id)
    ->where('payment_status', '00')
    ->where('statuspesanan', '00')
    ->orderBy('created_at', 'desc')
    ->get();
    $canceledkuliner = Pesankuliner::where('wisatawan_id', $wisatawan->id)
    ->where(function ($query) {
        $query->where('payment_status', '22')
              ->orWhere('payment_status', '33');
    })
    ->orderBy('created_at', 'desc')
    ->get();

    $pesanakomodasi = Reserv::where('wisatawan_id', $wisatawan->id)
    ->where('payment_status', '00')
    ->where('statuspemakaian', '00')
    ->orderBy('created_at', 'desc')
    ->get();
    $canceledakomodasi = Reserv::where('wisatawan_id', $wisatawan->id)
    ->where(function ($query) {
        $query->where('payment_status', '22')
              ->orWhere('payment_status', '33');
    })
    ->orderBy('created_at', 'desc')
    ->get();


    return view('wisatawan.home', compact(
        'pesantiket',
        'canceled',
        'pesankuliner',
        'canceledkuliner',
        'pesanakomodasi',
        'canceledakomodasi',
        'jumlah_dipakai',
        'jumlah_belumdibayar',
        'jumlah_belumdipakai',
        'jumlah_kadaluarsa',
        'jumlah_selesai',
        'jumlah_kulinerbelumdibayar',
        'jumlah_kulinerkadaluarsa',
        'jumlah_selesaiakomodasi',
        'jumlah_akomodasibelumdibayar',
        'jumlah_akomodasikadaluarsa'
    ));
}
}
