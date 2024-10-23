<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Http\Resources\PesantiketResource;
use App\Events\WisataViewEvent;
use App\Http\Resources\TiketResource;
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

class PesanTiketApiController extends Controller
{
    public function pesantiket($id)
    {
        try {
            // Fetch data with relations and ensure it is active
            $datawisata = Wisata::where('active', 1)->with(['hargatiket', 'created_by'])->findOrFail($id);
            // Transform data using resource
            $wisatas = new PesantiketResource($datawisata);

            // Return success response with data
            return response()->json([
                'message' => 'Data retrieved',
                'success' => true,
                'data' => $wisatas
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
            'harga_tiket_id' => 'required|array',
            'wisata_id' => 'required|integer',
            'wisatawan_id' => 'required|integer',
            'namawisata' => 'required|string|max:255',
            'metodepembayaran' => 'required|string|max:255',
            'tanggalkunjungan' => 'required|date',
            'jumlah.*' => 'required|integer|min:1',
            'harga.*' => 'required|numeric|min:0',
            'kategori.*' => 'required|string|max:255',
            'totalHarga' => 'required|numeric|min:0',
        ]);
        
        $wisatawan = Wisatawan::findOrFail($validatedData['wisatawan_id']);

        // Mulai transaksi database
        DB::beginTransaction();
        
        // Buat Pesantiket baru
        $pesantiket = Pesantiket::create([
            'kodetiket' => $this->generateTicketCode($validatedData['wisata_id'], $validatedData['namawisata']),
            'number' => $this->generateRandomNumber(8),
            'wisatawan_id' => $validatedData['wisatawan_id'],
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
        
        DB::commit();

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken,
            'kodetiket' => $pesantiket->kodetiket,
            'pesantiket_id' => $pesantiket->id,
            'namawisatawan' => $wisatawan->name,
            'namawisata' => $validatedData['namawisata'],
            'metodepembayaran' => $pesantiket->metodepembayaran,
            'created_at' => $pesantiket->created_at,
            'tanggalkunjungan' => $pesantiket->tanggalkunjungan,
            'totalHarga' => $pesantiket->totalHarga,
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

    private function generateTicketCode($wisata_id, $namawisata)
    {
        $namawisataArray = is_string($namawisata) ? explode(" ", $namawisata) : [];
        $namawisataInitial = count($namawisataArray) > 0 ? strtoupper(substr($namawisataArray[0], 0, 1)) : ''; // Mengambil huruf pertama dari namawisata jika ada
        $singkatan = $this->generateAbbreviation($namawisata);
        $tanggal = date('dmy');
        $lastOrder = Pesantiket::max('id') + 1;

        return 'TCKT-' . $wisata_id . '-' . $singkatan . '-' . $tanggal . '-' . str_pad($lastOrder, 4, '0', STR_PAD_LEFT);
    }

    private function generateAbbreviation($namawisata) {
        $words = explode(" ", $namawisata);
        $abbreviation = "";
        foreach ($words as $word) {
            $abbreviation .= strtoupper(substr($word, 0, 1));
        }
        return $abbreviation;
    }

    public function cetaktiket($kodetiket)
{
    // Cari pesantiket berdasarkan kodetiket dengan join ke tabel Wisata dan Wisatawan
    $pesantiket = Pesantiket::select('pesantiket.*', 'wisatas.namawisata as namawisata', 'wisatawan.name as name')
        ->leftJoin('wisatas', 'pesantiket.wisata_id', '=', 'wisatas.id')
        ->leftJoin('wisatawan', 'pesantiket.wisatawan_id', '=', 'wisatawan.id')
        ->where('kodetiket', $kodetiket)
        ->first();

    // Jika pesantiket tidak ditemukan, kembalikan response Not Found
    if (!$pesantiket) {
        return response()->json(['Oops' => 'Tiket not found'], Response::HTTP_NOT_FOUND);
    }

    // Ambil pesantiketDetails berdasarkan pesantiket_id
    $pesantiketDetails = PesananTiketDetail::where('pesantiket_id', $pesantiket->id)->get();

    // Kembalikan data dalam format JSON dengan nama wisata dan nama wisatawan
    return response()->json([
        'pesantiket' => $pesantiket,
        'pesantiketDetails' => $pesantiketDetails,
        'success' => true,
    ], 200);
}

public function pesanantiketwisatawan($id)
{
    // Find the wisatawan or fail
    $wisatawan = Wisatawan::findOrFail($id);

    // Get pesantiket for the wisatawan, order by created_at, and include related wisata and pesananTiketDetails
    $pesantiket = Pesantiket::where('wisatawan_id', $wisatawan->id)
        ->with(['wisata', 'pesananTiketDetails']) // Eager load wisata and pesananTiketDetails
        ->orderBy('created_at', 'desc')
        ->get();

    // If no pesantiket found, return response indicating no history
    if ($pesantiket->isEmpty()) {
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

    // Calculate the total 'jumlah' for each pesantiket and include 'thumbnail_url', 'namawisata', and status descriptions
    $pesantiket->transform(function ($item) use ($paymentStatusMapping, $statusPemakaianMapping) {
        $item->total_jumlah = $item->pesananTiketDetails->sum('jumlah');
        $item->thumbnail = $item->wisata->thumbnail; // Include thumbnail_url from related wisata
        $item->namawisata = $item->wisata->namawisata; // Include namawisata from related wisata
        $item->payment_status_description = $paymentStatusMapping[$item->payment_status]; // Map payment_status to description
        $item->statuspemakaian_description = $statusPemakaianMapping[$item->statuspemakaian]; // Map statuspemakaian to description
        unset($item->wisata); // Remove the entire wisata relationship data
        return $item;
    });
    return response()->json([
        'message' => 'Histori Tiket Wisata',
        'success' => true,
        'data' => $pesantiket
    ], 200);
    
}



public function checkoutFinishApi(Request $request)
{
    try {
        $kodetiket = $request->input('kodetiket');
        
        // Ambil data pesantiket berdasarkan kodetiket
        $pesantiket = Pesantiket::where('kodetiket', $kodetiket)->first();

        if (!$pesantiket) {
            return response()->json([
                'success' => false,
                'message' => 'Pesantiket dengan kode tiket tersebut tidak ditemukan.'
            ], 404);
        }

        // Ambil detail pesantiket
        $pesantiketDetails = PesananTiketDetail::where('pesantiket_id', $pesantiket->id)->get();

        // Ambil nama wisata dari relasi wisata_id
        $namawisata = $pesantiket->wisata->namawisata;

        // Ambil nama wisatawan dari relasi wisatawan_id
        $namawisatawan = $pesantiket->wisatawan->name;

        // Format tanggal created_at
        $formattedDate = $pesantiket->created_at->format('Y-m-d H:i:s');

        return response()->json([
            'success' => true,
            'data' => [
                'pesantiket' => [
                    'id' => $pesantiket->id,
                    'namawisata' => $namawisata,
                    'namawisatawan' => $namawisatawan,
                    'metodepembayaran' => $pesantiket->metodepembayaran,
                    'created_at' => $formattedDate,
                    'tanggalkunjungan' => $pesantiket->tanggalkunjungan,
                    'totalHarga' => $pesantiket->totalHarga,
                ],
                'pesantiketDetails' => $pesantiketDetails
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengambil data pesantiket: ' . $e->getMessage()
        ], 500);
    }
}






}
