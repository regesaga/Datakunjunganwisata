<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\KulinerProduk;
use App\Models\Reserv;
use App\Models\Reservation;
use App\Models\Pesankuliner;
use App\Models\PesananKulinerDetail;
use App\Events\WisataViewEvent;
use App\Models\Wisata;
use App\Models\Wisatawan;
use App\Models\User;
use App\Models\HargaTiket;
use App\Models\Pesantiket;
use App\Models\PesananTiketDetail;
use App\Models\CategoryWisata;
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
use App\Services\Midtrans\CallbackService;


class CallbackPaymentController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        // Set midtrans configuration
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }


public function receive()
{
    $callback = new CallbackService;

    if ($callback->isSignatureKeyVerified()) {
        $notification = $callback->getNotification();
        $order = $callback->getOrder();

        Log::info('Notification received:', ['notification' => $notification, 'order' => $order->payment_status]);

        if ($callback->isSuccess()) {
            if ($order instanceof Pesantiket) {
                Pesantiket::where('id', $order->id)->update(['payment_status' => '11']);
            } elseif ($order instanceof Pesankuliner) {
                Pesankuliner::where('id', $order->id)->update(['payment_status' => '11']);
            } elseif ($order instanceof Reserv) {
                Reserv::where('id', $order->id)->update(['payment_status' => '11']);
            }
        }
        
        if ($callback->isExpire()) {
            if ($order instanceof Pesantiket) {
                Pesantiket::where('id', $order->id)->update(['statuspemakaian' => '22', 'payment_status' => '22']);
            } elseif ($order instanceof Pesankuliner) {
                Pesankuliner::where('id', $order->id)->update(['statuspesanan' => '22', 'payment_status' => '22']);
            } elseif ($order instanceof Reserv) {
                Reserv::where('id', $order->id)->update(['statuspemakaian' => '22', 'payment_status' => '22']);
            }
        }

        if ($callback->isCancelled()) {
            if ($order instanceof Pesantiket) {
                Pesantiket::where('id', $order->id)->update(['statuspemakaian' => '22', 'payment_status' => '33']);
            } elseif ($order instanceof Pesankuliner) {
                Pesankuliner::where('id', $order->id)->update(['statuspesanan' => '22', 'payment_status' => '33']);
            } elseif ($order instanceof Reserv) {
                Reserv::where('id', $order->id)->update(['statuspemakaian' => '22', 'payment_status' => '33']);
            }
        }

       
        return response()
            ->json([
                'success' => true,
                'message' => 'Notifikasi berhasil diproses',
            ]);
    } else {
        Log::warning('Invalid signature key:', ['notification' => $callback->getNotification()]);

        return response()
            ->json([
                'error' => true,
                'message' => 'Signature key tidak terverifikasi',
            ], 403);
    }
}
}
