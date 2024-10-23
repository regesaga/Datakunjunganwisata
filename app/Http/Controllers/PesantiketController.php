<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Events\WisataViewEvent;
use App\Models\Wisata;
use App\Models\Wisatawan;
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
use App\Services\Midtrans\CallbackService;



class PesantiketController extends Controller
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
        // $wisataId = Cryptography::decryptString($wisata);
         $wisataId = $hash->decodeHex($id);
        $wisata= Wisata::find($wisataId);
        if(is_null($wisata)){
            return back();
        }


        $hargatiket = $wisata->hargatiket;
        $baner = Baner::all();
        // Menampilkan halaman pesanan tiket dengan data varian dan harga tiket
        return view('website.pesantiket.index', compact('hargatiket', 'baner','wisata'));
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
                'harga_tiket_id' => 'required|array',
                'wisata_id' => 'required',
                'namawisata' => 'required',
                'metodepembayaran' => 'required',
                'tanggalkunjungan' => 'required',
                'jumlah.*' => 'required',
                'harga.*' => 'required',
                'kategori.*' => 'required',
                'totalHarga' => 'required',
            ]);
    
            // Mulai transaksi database
            DB::beginTransaction();
            
            // Buat Pesantiket baru
            $pesantiket = Pesantiket::create([
                'kodetiket' => $this->generateTicketCode($validatedData['wisata_id'], $validatedData['namawisata']),
                'number' => $this->generateRandomNumber(8),
                'wisatawan_id' => $wisatawan->id,
                'wisata_id' => $validatedData['wisata_id'],
                'totalHarga' => $validatedData['totalHarga'],
                'metodepembayaran' => $validatedData['metodepembayaran'],
                'tanggalkunjungan' => $validatedData['tanggalkunjungan'],
            ]);
            
    
            $totalHarga = 0; // Inisialisasi total harga
            $itemDetails = []; // Inisialisasi array untuk item details
    
            foreach ($validatedData['harga_tiket_id'] as $index => $hargaTiketId) {
                $kategori = $validatedData['kategori'][$index];
                $jumlah = $validatedData['jumlah'][$index];
                $harga = $validatedData['harga'][$index];
    
                // Jika jumlah tiket adalah 0, lewati proses untuk tiket tersebut
                if ($jumlah == 0) {
                    continue;
                }
    
                // Ambil harga dari tabel harga_tikets berdasarkan ID
                $hargaTiket = HargaTiket::find($hargaTiketId);
    
                if (!$hargaTiket) {
                    // Handle error jika harga_tiket_id tidak ditemukan
                    throw new \Exception("Harga tiket dengan ID $hargaTiketId tidak ditemukan.");
                }
    
                $totalHarga += $harga * $jumlah;
    
                // Buat detail pesanan tiket dan tambahkan ke item details
                $detailpesantiket = PesananTiketDetail::create([
                    'pesantiket_id' => $pesantiket->id,
                    'harga_tiket_id' => $hargaTiketId,
                    'kategori' => $kategori,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                   
                ]);
    
                $itemDetails[] = [
                    'id'       => $detailpesantiket->id,
                    'name'    => $detailpesantiket->kategori,
                    'price'    => $detailpesantiket->harga,
                    'quantity' => $detailpesantiket->jumlah,
                ];
            }
    
            // Update total harga pada Pesantiket
            $pesantiket->update(['totalHarga' => $totalHarga]);
    
            // Buat payload untuk Snap
            $payload = [
                'transaction_details' => [
                    'order_id'      => $pesantiket->number,
                    'gross_amount'  => $pesantiket->totalHarga,
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
            $pesantiket->snap_token = $snapToken;
            $pesantiket->save();
            $this->response['snap_token'] = $snapToken;
            $this->response['kodetiket'] = $pesantiket->kodetiket;
            // Commit transaksi database
            DB::commit();
    
            // Log berhasil menyimpan data
            Log::info('Data Berhasil Di Input', [
                 'wisatawan_id' => $wisatawan->id,
                'wisata_id' => $validatedData['wisata_id'],
                'pesantiket_id' => $pesantiket->id,
                'totalHarga' => $totalHarga,
                'metodepembayaran' => $validatedData['metodepembayaran'],
                'tanggalkunjungan' => $validatedData['tanggalkunjungan'],
            ]);
            return response()->json($this->response);
            return response()->json(['status' => 'success', 'kodetiket' => $pesantiket->kodetiket]);
            return back()->with('status', 'Data Berhasil Di Input');
        } catch (\Throwable $th) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage(), [
                'error' => $th->getMessage(),
                'wisatawan_id' => $wisatawan->id,
                'request_data' => $request->all(),
            ]);
            return redirect()->route('website.destinasi')
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
private function generateTicketCode($wisata_id, $namawisata)
{
    // Memeriksa apakah $namawisata adalah string sebelum menggunakan explode()
    $namawisataArray = is_string($namawisata) ? explode(" ", $namawisata) : [];
    $namawisataInitial = count($namawisataArray) > 0 ? strtoupper(substr($namawisataArray[0], 0, 1)) : ''; // Mengambil huruf pertama dari namawisata jika ada

    // Singkatan untuk nama wisata
    $singkatan = $this->generateAbbreviation($namawisata);

    // Mendapatkan tanggal dengan format ddmmyy
    $tanggal = date('dmy');

    // Mendapatkan nomor urut terakhir dari tabel pesantiket
    $lastOrder = Pesantiket::max('id') + 1;

    // Menggunakan format yang sesuai untuk kode tiket
    return 'TCKT-' . $wisata_id . '-' . $singkatan . '-' . $tanggal . '-' . str_pad($lastOrder, 4, '0', STR_PAD_LEFT);
}

// Fungsi untuk menghasilkan singkatan dari nama wisata
private function generateAbbreviation($namawisata) {
    $words = explode(" ", $namawisata);
    $abbreviation = "";
    foreach ($words as $word) {
        $abbreviation .= strtoupper(substr($word, 0, 1));
    }
    return $abbreviation;
}

public function checkoutFinish($kodetiket)
    {
        if (!Auth::guard('wisatawans')->check()) {
            // Redirect to the login page
            return redirect()->route('wisatawan.login')->with('silahkan login sebagai wisatawan');
        }
        $pesantiket = Pesantiket::where('kodetiket', $kodetiket)->first();
        $pesantiketDetails  = PesananTiketDetail::where('pesantiket_id', $pesantiket->id)->get();
        return view('website.pesantiket.checkout_finish', compact('pesantiket', 'pesantiketDetails'));
    }


    

   
}