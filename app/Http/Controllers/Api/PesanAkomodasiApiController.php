<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Akomodasi;
use App\Http\Resources\PesanakomodasiResource;
use App\Events\AkomodasiViewEvent;
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

class PesanAkomodasiApiController extends Controller
{
    public function reserv($id)
    {
        try {
            // Fetch data with relations and ensure it is active
            $dataakomodasi = Akomodasi::where('active', 1)->with(['created_by'])->findOrFail($id);
            // Transform data using resource
            $akomodasis = new PesanakomodasiResource($dataakomodasi);

            // Return success response with data
            return response()->json([
                'message' => 'Data retrieved',
                'success' => true,
                'data' => $akomodasis
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
            'room_id' => 'required|array',
            'akomodasi_id' => 'required|integer',
            'wisatawan_id' => 'required|integer',
            'namaakomodasi' => 'required|string|max:255',
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
        
        // Buat Reserv baru
        $reserv = Reserv::create([
            'kodeboking' => $this->generateTicketCode($validatedData['akomodasi_id'], $validatedData['namaakomodasi']),
            'number' => $this->generateRandomNumber(8),
            'wisatawan_id' => $validatedData['wisatawan_id'],
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

            // Ambil harga dari tabel harga_tikets berdasarkan ID
            $hargaTiket = Rooms::find($roomId);

            if (!$hargaTiket) {
                throw new \Exception("Harga tiket dengan ID $roomId tidak ditemukan.");
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
        
        DB::commit();

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken,
            'kodeboking' => $reserv->kodeboking,
            'reserv_id' => $reserv->id,
            'namawisatawan' => $wisatawan->name,
            'namaakomodasi' => $validatedData['namaakomodasi'],
            'metodepembayaran' => $reserv->metodepembayaran,
            'created_at' => $reserv->created_at,
            'tanggalkunjungan' => $reserv->tanggalkunjungan,
            'totalHarga' => $reserv->totalHarga,
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

    private function generateTicketCode($akomodasi_id, $namaakomodasi)
    {
        $namaakomodasiArray = is_string($namaakomodasi) ? explode(" ", $namaakomodasi) : [];
        $namaakomodasiInitial = count($namaakomodasiArray) > 0 ? strtoupper(substr($namaakomodasiArray[0], 0, 1)) : ''; // Mengambil huruf pertama dari namaakomodasi jika ada
        $singkatan = $this->generateAbbreviation($namaakomodasi);
        $tanggal = date('dmy');
        $lastOrder = Reserv::max('id') + 1;

        return 'RESERV-' . $akomodasi_id . '-' . $singkatan . '-' . $tanggal . '-' . str_pad($lastOrder, 4, '0', STR_PAD_LEFT);
    }

    private function generateAbbreviation($namaakomodasi) {
        $words = explode(" ", $namaakomodasi);
        $abbreviation = "";
        foreach ($words as $word) {
            $abbreviation .= strtoupper(substr($word, 0, 1));
        }
        return $abbreviation;
    }

    public function cetakreserv($kodeboking)
{
    // Cari reserv berdasarkan kodeboking dengan join ke tabel Akomodasi dan Wisatawan
    $reserv = Reserv::select('reserv.*', 'akomodasis.namaakomodasi as namaakomodasi', 'wisatawan.name as name')
        ->leftJoin('akomodasis', 'reserv.akomodasi_id', '=', 'akomodasis.id')
        ->leftJoin('wisatawan', 'reserv.wisatawan_id', '=', 'wisatawan.id')
        ->where('kodeboking', $kodeboking)
        ->first();

    // Jika reserv tidak ditemukan, kembalikan response Not Found
    if (!$reserv) {
        return response()->json(['Oops' => 'Tiket not found'], Response::HTTP_NOT_FOUND);
    }

    // Ambil reservation berdasarkan reserv_id
    $reservation = Reservation::where('reserv_id', $reserv->id)->get();

    // Kembalikan data dalam format JSON dengan nama akomodasi dan nama wisatawan
    return response()->json([
        'reserv' => $reserv,
        'reservation' => $reservation,
        'success' => true,
    ], 200);
}

public function riwayatreserv($id)
{
    // Find the wisatawan or fail
    $wisatawan = Wisatawan::findOrFail($id);

    // Get reserv for the wisatawan, order by created_at, and include related akomodasi and Reservation
    $reserv = Reserv::where('wisatawan_id', $wisatawan->id)
        ->with(['akomodasi', 'Reservation']) // Eager load akomodasi and Reservation
        ->orderBy('created_at', 'desc')
        ->get();

    // If no reserv found, return response indicating no history
    if ($reserv->isEmpty()) {
        return response()->json([
            'message' => 'Belum ada riwayat rESERVASIOAN',
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

    // Calculate the total 'jumlah' for each reserv and include 'thumbnail_url', 'namaakomodasi', and status descriptions
    $reserv->transform(function ($item) use ($paymentStatusMapping, $statusPemakaianMapping) {
        $item->total_jumlah = $item->Reservation->sum('jumlah');
        $item->thumbnail = $item->akomodasi->thumbnail; // Include thumbnail_url from related akomodasi
        $item->namaakomodasi = $item->akomodasi->namaakomodasi; // Include namaakomodasi from related akomodasi
        $item->payment_status_description = $paymentStatusMapping[$item->payment_status]; // Map payment_status to description
        $item->statuspemakaian_description = $statusPemakaianMapping[$item->statuspemakaian]; // Map statuspemakaian to description
        unset($item->akomodasi); // Remove the entire akomodasi relationship data
        return $item;
    });
    return response()->json([
        'message' => 'Histori Tiket Akomodasi',
        'success' => true,
        'data' => $reserv
    ], 200);
    
}


public function checkoutReservFinishApi(Request $request)
{
    try {
        $kodeboking = $request->input('kodeboking');
        
        // Ambil data reserv berdasarkan kodeboking
        $reserv = Reserv::where('kodeboking', $kodeboking)->first();

        if (!$reserv) {
            return response()->json([
                'success' => false,
                'message' => 'Reserv dengan kode tiket tersebut tidak ditemukan.'
            ], 404);
        }

        // Ambil detail reserv
        $reservation = Reservation::where('reserv_id', $reserv->id)->get();

        // Ambil nama akomodasi dari relasi akomodasi_id
        $namaakomodasi = $reserv->akomodasi->namaakomodasi;

        // Ambil nama wisatawan dari relasi wisatawan_id
        $namawisatawan = $reserv->wisatawan->name;

        // Format tanggal created_at
        $formattedDate = $reserv->created_at->format('Y-m-d H:i:s');

        return response()->json([
            'success' => true,
            'data' => [
                'reserv' => [
                    'id' => $reserv->id,
                    'namaakomodasi' => $namaakomodasi,
                    'namawisatawan' => $namawisatawan,
                    'metodepembayaran' => $reserv->metodepembayaran,
                    'created_at' => $formattedDate,
                    'tanggalkunjungan' => $reserv->tanggalkunjungan,
                    'totalHarga' => $reserv->totalHarga,
                ],
                'reservation' => $reservation
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengambil data reserv: ' . $e->getMessage()
        ], 500);
    }
}






}
