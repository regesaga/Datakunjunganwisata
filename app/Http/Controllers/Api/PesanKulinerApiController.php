<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Kuliner;
use App\Http\Resources\PesankulinerResource;
use App\Events\KulinerViewEvent;
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

class PesanKulinerApiController extends Controller
{
    public function pesankuliner($id)
    {
        try {
            // Fetch data with relations and ensure it is active
            $datakuliner = Kuliner::where('active', 1)->with(['created_by'])->findOrFail($id);
            // Transform data using resource
            $kuliners = new PesankulinerResource($datakuliner);

            // Return success response with data
            return response()->json([
                'message' => 'Data retrieved',
                'success' => true,
                'data' => $kuliners
            ], 200);
        } catch (\Exception $e) {
            // Handle error and return response
            return response()->json([
                'message' => 'Data not found',
                'success' => false,
                'Oops' => $e->getMessage()
            ], 404);
        }
    }


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


    public function store(Request $request)
{
    try {
       
        // Validasi request data
        $validatedData = $request->validate([
            'kulinerproduk_id' => 'required|array',
            'kuliner_id' => 'required|integer',
            'wisatawan_id' => 'required|integer',
            'namakuliner' => 'required|string|max:255',
            'metodepembayaran' => 'required|string|max:255',
            'tanggalkunjungan' => 'required|date',
            'jumlah.*' => 'required|integer|min:1',
            'harga.*' => 'required|numeric|min:0',
            'nama.*' => 'required|string|max:255',
            'totalHarga' => 'required|numeric|min:0',
        ]);
        
        $wisatawan = Wisatawan::findOrFail($validatedData['wisatawan_id']);

        // Mulai transaksi database
        DB::beginTransaction();
        
        // Buat Pesankuliner baru
        $pesankuliner = Pesankuliner::create([
            'kodepesanan' => $this->generateTicketCode($validatedData['kuliner_id'], $validatedData['namakuliner']),
            'number' => $this->generateRandomNumber(8),
            'wisatawan_id' => $validatedData['wisatawan_id'],
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

            // Ambil harga dari tabel harga_tikets berdasarkan ID
            $hargaTiket = Kulinerproduk::find($kulinerProdukId);

            if (!$hargaTiket) {
                throw new \Exception("Harga tiket dengan ID $kulinerProdukId tidak ditemukan.");
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
        
        DB::commit();

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken,
            'kodepesanan' => $pesankuliner->kodepesanan,
            'pesankuliner_id' => $pesankuliner->id,
            'namawisatawan' => $wisatawan->name,
            'namakuliner' => $validatedData['namakuliner'],
            'metodepembayaran' => $pesankuliner->metodepembayaran,
            'created_at' => $pesankuliner->created_at,
            'tanggalkunjungan' => $pesankuliner->tanggalkunjungan,
            'totalHarga' => $pesankuliner->totalHarga,
            'item_details' => $itemDetails,
        ]);
    } catch (\Throwable $th) {
        DB::rollback();
        Log::error('Gagal menyimpan data ke database: ' . $th->getMessage(), [
            'Oops' => $th->getMessage(),
            'wisatawan_id' => $wisatawan->id ?? null,
            'request_data' => $request->all(),
        ]);
        return response()->json(['Oops' => 'Terjadi kesalahan saat menyimpan pemesanan tiket. Silakan coba lagi nanti.'], 500);
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

    private function generateTicketCode($kuliner_id, $namakuliner)
    {
        $namakulinerArray = is_string($namakuliner) ? explode(" ", $namakuliner) : [];
        $namakulinerInitial = count($namakulinerArray) > 0 ? strtoupper(substr($namakulinerArray[0], 0, 1)) : ''; // Mengambil huruf pertama dari namakuliner jika ada
        $singkatan = $this->generateAbbreviation($namakuliner);
        $tanggal = date('dmy');
        $lastOrder = Pesankuliner::max('id') + 1;

        return 'PSNKLN-' . $kuliner_id . '-' . $singkatan . '-' . $tanggal . '-' . str_pad($lastOrder, 4, '0', STR_PAD_LEFT);
    }

    private function generateAbbreviation($namakuliner) {
        $words = explode(" ", $namakuliner);
        $abbreviation = "";
        foreach ($words as $word) {
            $abbreviation .= strtoupper(substr($word, 0, 1));
        }
        return $abbreviation;
    }

    public function cetakpesanan($kodepesanan)
{
    // Cari pesankuliner berdasarkan kodepesanan dengan join ke tabel Kuliner dan Wisatawan
    $pesankuliner = Pesankuliner::select('pesankuliner.*', 'kuliners.namakuliner as namakuliner', 'wisatawan.name as name')
        ->leftJoin('kuliners', 'pesankuliner.kuliner_id', '=', 'kuliners.id')
        ->leftJoin('wisatawan', 'pesankuliner.wisatawan_id', '=', 'wisatawan.id')
        ->where('kodepesanan', $kodepesanan)
        ->first();

    // Jika pesankuliner tidak ditemukan, kembalikan response Not Found
    if (!$pesankuliner) {
        return response()->json(['Oops' => 'Tiket not found'], Response::HTTP_NOT_FOUND);
    }

    // Ambil pesankulinerDetails berdasarkan pesankuliner_id
    $pesankulinerDetails = PesananKulinerDetail::where('pesankuliner_id', $pesankuliner->id)->get();

    // Kembalikan data dalam format JSON dengan nama kuliner dan nama wisatawan
    return response()->json([
        'pesankuliner' => $pesankuliner,
        'pesankulinerDetails' => $pesankulinerDetails,
        'success' => true,
    ], 200);
}

public function pesanankulinerwisatawan($id)
{
    // Find the wisatawan or fail
    $wisatawan = Wisatawan::findOrFail($id);

    // Get pesankuliner for the wisatawan, order by created_at, and include related kuliner and PesananKulinerDetail
    $pesankuliner = Pesankuliner::where('wisatawan_id', $wisatawan->id)
        ->with(['kuliner', 'PesananKulinerDetail']) // Eager load kuliner and PesananKulinerDetail
        ->orderBy('created_at', 'desc')
        ->get();

    // If no pesankuliner found, return response indicating no history
    if ($pesankuliner->isEmpty()) {
        return response()->json([
            'message' => 'Belum ada riwayat pesan tiket',
            'success' => true, // Set success to true or false as needed
        ], 200);
    }

    // Mapping payment_status to human-readable strings
    $paymentStatusMapping = [
        00 => 'Menunggu pembayaran',
        11 => 'Sudah dibayar',
        22 => 'Kadaluarsa',
        33 => 'Batal',
    ];

    // Mapping statuspemakaian to human-readable strings
    $statusPemakaianMapping = [
        00 => 'Belum terpakai',
        11 => 'Sudah terpakai',
        22 => 'Kadaluarsa',
    ];

    // Calculate the total 'jumlah' for each pesankuliner and include 'thumbnail_url', 'namakuliner', and status descriptions
    $pesankuliner->transform(function ($item) use ($paymentStatusMapping, $statusPemakaianMapping) {
        $item->total_jumlah = $item->PesananKulinerDetail->sum('jumlah');
        $item->thumbnail = $item->kuliner->thumbnail; // Include thumbnail_url from related kuliner
        $item->namakuliner = $item->kuliner->namakuliner; // Include namakuliner from related kuliner
        $item->payment_status_description = $paymentStatusMapping[$item->payment_status]; // Map payment_status to description
        $item->statuspemakaian_description = $statusPemakaianMapping[$item->statuspemakaian]; // Map statuspemakaian to description
        unset($item->kuliner); // Remove the entire kuliner relationship data
        return $item;
    });
    return response()->json([
        'message' => 'Histori Tiket Kuliner',
        'success' => true,
        'data' => $pesankuliner
    ], 200);
    
}


public function checkoutkulinerFinishApi(Request $request)
{
    try {
        $kodepesanan = $request->input('kodepesanan');
        
        // Ambil data pesankuliner berdasarkan kodepesanan
        $pesankuliner = Pesankuliner::where('kodepesanan', $kodepesanan)->first();

        if (!$pesankuliner) {
            return response()->json([
                'success' => false,
                'message' => 'Pesankuliner dengan kode tiket tersebut tidak ditemukan.'
            ], 404);
        }

        // Ambil detail pesankuliner
        $pesankulinerDetails = PesananKulinerDetail::where('pesankuliner_id', $pesankuliner->id)->get();

        // Ambil nama kuliner dari relasi kuliner_id
        $namakuliner = $pesankuliner->kuliner->namakuliner;

        // Ambil nama wisatawan dari relasi wisatawan_id
        $namawisatawan = $pesankuliner->wisatawan->name;

        // Format tanggal created_at
        $formattedDate = $pesankuliner->created_at->format('Y-m-d H:i:s');

        return response()->json([
            'success' => true,
            'data' => [
                'pesankuliner' => [
                    'id' => $pesankuliner->id,
                    'namakuliner' => $namakuliner,
                    'namawisatawan' => $namawisatawan,
                    'metodepembayaran' => $pesankuliner->metodepembayaran,
                    'created_at' => $formattedDate,
                    'tanggalkunjungan' => $pesankuliner->tanggalkunjungan,
                    'totalHarga' => $pesankuliner->totalHarga,
                ],
                'pesankulinerDetails' => $pesankulinerDetails
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengambil data pesankuliner: ' . $e->getMessage()
        ], 500);
    }
}






}
