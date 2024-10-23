<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Events\KulinerViewEvent;
use App\Models\Kuliner;
use App\Models\Wisatawan;
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
use App\Services\Midtrans\KulinerCallbackService;



class PesankulinerController extends Controller
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
        // $kulinerId = Cryptography::decryptString($kuliner);
         $kulinerId = $hash->decodeHex($id);
        $kuliner= Kuliner::find($kulinerId);
        if(is_null($kuliner)){
            return back();
        }


        $kulinerproduk = $kuliner->kulinerproduk()->where('active', 1)->get();
        $baner = Baner::all();
        // Menampilkan halaman pesanan tiket dengan data varian dan harga tiket
        return view('website.pesankuliner.index', compact('kulinerproduk', 'baner','kuliner'));
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
                'kulinerproduk_id' => 'required|array',
                'kuliner_id' => 'required',
                'namakuliner' => 'required',
                'metodepembayaran' => 'required',
                'tanggalkunjungan' => 'required',
                'jumlah.*' => 'required',
                'harga.*' => 'required',
                'nama.*' => 'required',
                'totalHarga' => 'required',
            ]);
    
            // Mulai transaksi database
            DB::beginTransaction();
            
            // Buat Pesankuliner baru
            $pesankuliner = Pesankuliner::create([
                'kodepesanan' => $this->generateTicketCode($validatedData['kuliner_id'], $validatedData['namakuliner']),
                'number' => $this->generateRandomNumber(8),
                'wisatawan_id' => $wisatawan->id,
                'kuliner_id' => $validatedData['kuliner_id'],
                'totalHarga' => $validatedData['totalHarga'],
                'metodepembayaran' => $validatedData['metodepembayaran'],
                'tanggalkunjungan' => $validatedData['tanggalkunjungan'],
            ]);
            
    
            $totalHarga = 0; // Inisialisasi total harga
            $itemDetails = []; // Inisialisasi array untuk item details
    
            foreach ($validatedData['kulinerproduk_id'] as $index => $kulinerProdukId) {
                $nama = $validatedData['nama'][$index];
                $jumlah = $validatedData['jumlah'][$index];
                $harga = $validatedData['harga'][$index];



                // Jika jumlah tiket adalah 0, lewati proses untuk tiket tersebut
                if ($jumlah == 0) {
                    continue;
                }

          
                $totalHarga += $harga * $jumlah;
               
                // Buat detail pesanan tiket dan tambahkan ke item details
                $detailpesankuliner = PesananKulinerDetail::create([
                    'pesankuliner_id' => $pesankuliner->id,
                    'kulinerproduk_id' => $kulinerProdukId,
                    'nama' => $nama,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                   
                ]);

                         

    
                $itemDetails[] = [
                    'id'       => $detailpesankuliner->id,
                    'name'    => $detailpesankuliner->nama,
                    'price'    => $detailpesankuliner->harga,
                    'quantity' => $detailpesankuliner->jumlah,
                ];
                
                
            }
    
            // Update total harga pada Pesankuliner
            $pesankuliner->update(['totalHarga' => $totalHarga]);
    
            // Buat payload untuk Snap
            $payload = [
                'transaction_details' => [
                    'order_id'      => $pesankuliner->number,
                    'gross_amount'  => $pesankuliner->totalHarga,
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
            $pesankuliner->snap_token = $snapToken;
            $pesankuliner->save();
            $this->response['snap_token'] = $snapToken;
            $this->response['kodepesanan'] = $pesankuliner->kodepesanan;
            // Commit transaksi database

            
            DB::commit();
    
            // Log berhasil menyimpan data
            Log::info('Data Berhasil Di Input', [
                 'wisatawan_id' => $wisatawan->id,
                'kuliner_id' => $validatedData['kuliner_id'],
                'pesankuliner_id' => $pesankuliner->id,
                'totalHarga' => $totalHarga,
                'metodepembayaran' => $validatedData['metodepembayaran'],
                'tanggalkunjungan' => $validatedData['tanggalkunjungan'],
            ]);
            return response()->json($this->response);
            return response()->json(['status' => 'success', 'kodepesanan' => $pesankuliner->kodepesanan]);
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
private function generateTicketCode($kuliner_id, $namakuliner)
{
    // Memeriksa apakah $namakuliner adalah string sebelum menggunakan explode()
    $namakulinerArray = is_string($namakuliner) ? explode(" ", $namakuliner) : [];
    $namakulinerInitial = count($namakulinerArray) > 0 ? strtoupper(substr($namakulinerArray[0], 0, 1)) : ''; // Mengambil huruf pertama dari namakuliner jika ada

    // Singkatan untuk nama wisata
    $singkatan = $this->generateAbbreviation($namakuliner);

    // Mendapatkan tanggal dengan format ddmmyy
    $tanggal = date('dmy');

    // Mendapatkan nomor urut terakhir dari tabel pesankuliner
    $lastOrder = Pesankuliner::max('id') + 1;

    // Menggunakan format yang sesuai untuk kode tiket
    return 'PSNKLN-' . $kuliner_id . '-' . $singkatan . '-' . $tanggal . '-' . str_pad($lastOrder, 4, '0', STR_PAD_LEFT);
}

// Fungsi untuk menghasilkan singkatan dari nama wisata
private function generateAbbreviation($namakuliner) {
    $words = explode(" ", $namakuliner);
    $abbreviation = "";
    foreach ($words as $word) {
        $abbreviation .= strtoupper(substr($word, 0, 1));
    }
    return $abbreviation;
}





    public function checkoutFinish($kodepesanan)
    {
        if (!Auth::guard('wisatawans')->check()) {
            // Redirect to the login page
            return redirect()->route('wisatawan.login')->with('silahkan login sebagai wisatawan');
        }
        $pesankuliner = Pesankuliner::where('kodepesanan', $kodepesanan)->first();
        $pesankulinerDetails  = PesananKulinerDetail::where('pesankuliner_id', $pesankuliner->id)->get();
        return view('website.pesankuliner.checkout_finish', compact('pesankuliner', 'pesankulinerDetails'));
    }
    
   
}