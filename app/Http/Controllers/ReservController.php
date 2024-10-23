<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Events\WisataViewEvent;
use App\Models\Akomodasi;
use App\Models\Wisatawan;
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
use App\Services\Midtrans\CallbackService;



class ReservController extends Controller
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
    public function index($id)
    {
          // Check if a wisatawan is authenticated
          if (!Auth::guard('wisatawans')->check()) {
            // Redirect to the login page
            return redirect()->route('wisatawan.login')->with('silahkan login sebagai wisatawan');
        }
        
        // Mengambil data wisata berdasarkan ID
      $hash = new Hashids();
        // $akomodasiId = Cryptography::decryptString($akomodasi);
         $akomodasiId = $hash->decodeHex($id);
        $akomodasi= Akomodasi::find($akomodasiId);
        if(is_null($akomodasi)){
            return back();
        }

        $room = $akomodasi->room()->where('active', 1)->get();
        $baner = Baner::all();
        // Menampilkan halaman pesanan tiket dengan data varian dan harga tiket
        return view('website.reserv.index', compact('room', 'baner','akomodasi'));
    }

    
 
    public function store(Request $request)
    {
        try {
            // Dapatkan wisatawan yang sedang login
           // Dapatkan wisatawan yang sedang login
            $wisatawan = Auth::guard('wisatawans')->user();

            // Pastikan wisatawan tidak null sebelum mengakses properti id
            if ($wisatawan) {
                $wisatawanId = $wisatawan->id;
            } else {
                return redirect()->route('wisatawan.login')->with('silahkan login sebagai wisatawan');
            }
    
            // Validasi request data
            $validatedData = $request->validate([
                'room_id' => 'required|array',
                'akomodasi_id' => 'required',
                'namaakomodasi' => 'required',
                'metodepembayaran' => 'required',
                'tanggalkunjungan' => 'required',
                'jumlah.*' => 'required',
                'harga.*' => 'required',
                'nama.*' => 'required',
                'totalHarga' => 'required',
            ]);
    
            // Mulai transaksi database
            DB::beginTransaction();
            
            // Buat Reserv baru
            $reserv = Reserv::create([
                'kodeboking' => $this->generateTicketCode($validatedData['akomodasi_id'], $validatedData['namaakomodasi']),
                'number' => $this->generateRandomNumber(8),
                'wisatawan_id' => $wisatawan->id,
                'akomodasi_id' => $validatedData['akomodasi_id'],
                'totalHarga' => $validatedData['totalHarga'],
                'metodepembayaran' => $validatedData['metodepembayaran'],
                'tanggalkunjungan' => $validatedData['tanggalkunjungan'],
            ]);
            
    
            $totalHarga = 0; // Inisialisasi total harga
            $itemDetails = []; // Inisialisasi array untuk item details
    
            foreach ($validatedData['room_id'] as $index => $roomId) {
                $nama = $validatedData['nama'][$index];
                $jumlah = $validatedData['jumlah'][$index];
                $harga = $validatedData['harga'][$index];
    
                // Jika jumlah tiket adalah 0, lewati proses untuk tiket tersebut
                if ($jumlah == 0) {
                    continue;
                }
    
             
    
                $totalHarga += $harga * $jumlah;
    
                // Buat detail pesanan tiket dan tambahkan ke item details
                $reservation = Reservation::create([
                    'reserv_id' => $reserv->id,
                    'room_id' => $roomId,
                    'nama' => $nama,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                   
                ]);
    
                $itemDetails[] = [
                    'id'       => $reservation->id,
                    'name'    => $reservation->nama,
                    'price'    => $reservation->harga,
                    'quantity' => $reservation->jumlah,
                ];
            }
    
            // Update total harga pada Reserv
            $reserv->update(['totalHarga' => $totalHarga]);
    
            // Buat payload untuk Snap
            $payload = [
                'transaction_details' => [
                    'order_id'      => $reserv->number,
                    'gross_amount'  => $reserv->totalHarga,
                ],
                'customer_details' => [
                    'name'    => $wisatawan->name,
                    'email'   => $wisatawan->email,
                    'phone'   => $wisatawan->phone,
                ],
                'item_details' => $itemDetails,
            ];
    
            // Dapatkan snap token
            $snapToken = Snap::getSnapToken($payload);
            $reserv->snap_token = $snapToken;
            $reserv->save();
            $this->response['snap_token'] = $snapToken;
            $this->response['kodeboking'] = $reserv->kodeboking;
            // Commit transaksi database
            DB::commit();
    
            // Log berhasil menyimpan data
            Log::info('Data Berhasil Di Input', [
                 'wisatawan_id' => $wisatawan->id,
                'akomodasi_id' => $validatedData['akomodasi_id'],
                'reserv_id' => $reserv->id,
                'totalHarga' => $totalHarga,
                'metodepembayaran' => $validatedData['metodepembayaran'],
                'tanggalkunjungan' => $validatedData['tanggalkunjungan'],
            ]);
            return response()->json($this->response);
            return response()->json(['status' => 'success', 'kodeboking' => $reserv->kodeboking]);
            return back()->with('status', 'Data Berhasil Di Input');
        } catch (\Throwable $th) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage(), [
                'error' => $th->getMessage(),
                'wisatawan_id' => $wisatawan->id,
                'request_data' => $request->all(),
            ]);
            return redirect()->route('website.akomodasi')
                             ->with('error', 'Terjadi kesalahan saat menyimpan pemesanan tiket. Silakan coba lagi nanti.');
        }
    }
    
    private function generateRandomNumber($length)
    {
        $number = '';
        for ($i = 0; $i < $length; $i++) {
            if ($i === 0) {
                $number .= mt_rand(1, 9);
            } else {
                $number .= mt_rand(0, 9);
            }
        }
        return $number;
    }
   // Fungsi untuk menghasilkan kode tiket
// Fungsi untuk menghasilkan kode tiket
private function generateTicketCode($akomodasi_id, $namaakomodasi)
{
    // Memeriksa apakah $namaakomodasi adalah string sebelum menggunakan explode()
    $namaakomodasiArray = is_string($namaakomodasi) ? explode(" ", $namaakomodasi) : [];
    $namaakomodasiInitial = count($namaakomodasiArray) > 0 ? strtoupper(substr($namaakomodasiArray[0], 0, 1)) : ''; // Mengambil huruf pertama dari namaakomodasi jika ada

    // Singkatan untuk nama wisata
    $singkatan = $this->generateAbbreviation($namaakomodasi);

    // Mendapatkan tanggal dengan format ddmmyy
    $tanggal = date('dmy');

    // Mendapatkan nomor urut terakhir dari tabel reserv
    $lastOrder = Reserv::max('id') + 1;

    // Menggunakan format yang sesuai untuk kode tiket
    return 'RESERV-' . $akomodasi_id . '-' . $singkatan . '-' . $tanggal . '-' . str_pad($lastOrder, 4, '0', STR_PAD_LEFT);
}

// Fungsi untuk menghasilkan singkatan dari nama wisata
private function generateAbbreviation($namaakomodasi) {
    $words = explode(" ", $namaakomodasi);
    $abbreviation = "";
    foreach ($words as $word) {
        $abbreviation .= strtoupper(substr($word, 0, 1));
    }
    return $abbreviation;
}

public function checkoutFinish($kodeboking)
    {
        if (!Auth::guard('wisatawans')->check()) {
            // Redirect to the login page
            return redirect()->route('wisatawan.login')->with('silahkan login sebagai wisatawan');
        }
        $reserv = Reserv::where('kodeboking', $kodeboking)->first();
        $reservation  = Reservation::where('reserv_id', $reserv->id)->get();
        return view('website.reserv.checkout_finish', compact('reserv', 'reservation'));
    }


    


    

   
}