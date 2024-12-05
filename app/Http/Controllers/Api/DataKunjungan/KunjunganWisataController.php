<?php

namespace App\Http\Controllers\Api\DataKunjungan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Evencalender;
use App\Models\WisnuWisata;
use App\Models\WisnuEvent;
use App\Models\KelompokKunjungan;
use App\Models\WismanWisata;
use App\Models\WismanEvent;
use App\Models\WismanNegara;
use App\Models\Wisata;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;

class KunjunganWisataController extends Controller
{
    public function dashboardwisata(Request $request)
    {
        
           
        $company_id = auth()->user()->company->id;
        $wisata = Wisata::where('company_id', $company_id)->first(); // Mendapatkan wisata terkait
        $hash = new Hashids();
    
        if (!$wisata) {
            return response()->json(['error' => 'Wisata tidak ditemukan untuk perusahaan Anda.'], 404);
        }
        $wisata_id = $wisata->id; // Dapatkan wisata_id untuk filtering data
        // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
        $year = $request->input('year', date('Y'));
        $userId = Auth::id();
        $events = Evencalender::where('created_by_id', $userId)->get();
        $event_calendar_id = $events->pluck('id')->toArray();  // Mengubah koleksi menjadi array
        $bytgl = [];
        $totalLakiLaki = 0;
        $totalPerempuan = 0;
        $totalWismanLaki = 0;
        $totalWismanPerempuan = 0;
        $totalKunjungan = 0;
        $awal = Carbon::createFromFormat('Y-m-d', "$year-01-01");
        $akhir = Carbon::createFromFormat('Y-m-d', "$year-12-31");
        for ($date = $awal; $date <= $akhir; $date->addDay()) {
            $tanggal = $date->format('Y-m-d');
            // Ambil data Wisnu Wisata
            $wisnuKunjungan = WisnuWisata::where('wisata_id', $wisata_id)
                ->whereDate('tanggal_kunjungan', $tanggal)
                ->get()
                ->groupBy('kelompok_kunjungan_id');
    
            // Ambil data Wisman Wisata
            $wismanKunjungan = WismanWisata::where('wisata_id', $wisata_id)
                ->whereDate('tanggal_kunjungan', $tanggal)
                ->get()
                ->groupBy('wismannegara_id');
            // Ambil data Wisnu Event
            $wisnuEvenKunjungan = WisnuEvent::whereIn('event_calendar_id', $event_calendar_id)
                ->whereDate('tanggal_kunjungan', $tanggal)
                ->get()
                ->groupBy('kelompok_kunjungan_id');
            // Ambil data Wisman Event
            $wismanEvenKunjungan = WismanEvent::whereIn('event_calendar_id', $event_calendar_id)
                ->whereDate('tanggal_kunjungan', $tanggal)
                ->get()
                ->groupBy('wismannegara_id');
    
            // Hitung total harian dari Wisnu Wisata dan Wisnu Event
            $jumlahLakiLaki = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki')) + $wisnuEvenKunjungan->flatMap(fn($group) => $group->pluck('jumlah_laki_laki'))->sum();
            $jumlahPerempuan = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan')) + $wisnuEvenKunjungan->flatMap(fn($group) => $group->pluck('jumlah_perempuan'))->sum();
            // Hitung total harian dari Wisman Wisata dan Wisman Event
            $jmlWismanLaki = $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_laki')) + $wismanEvenKunjungan->flatMap(fn($group) => $group->pluck('jml_wisman_laki'))->sum();
            $jmlWismanPerempuan = $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_perempuan')) + $wismanEvenKunjungan->flatMap(fn($group) => $group->pluck('jml_wisman_perempuan'))->sum();
            // Tambahkan ke total keseluruhan
            $totalLakiLaki += $jumlahLakiLaki;
            $totalPerempuan += $jumlahPerempuan;
            $totalWismanLaki += $jmlWismanLaki;
            $totalWismanPerempuan += $jmlWismanPerempuan;
            $totalKunjungan = $totalLakiLaki + $totalPerempuan + $totalWismanLaki + $totalWismanPerempuan;
            // Isi data pada tanggal tertentu
            $bytgl[$tanggal] = [
                'tanggal_kunjungan' => $tanggal,
                'jumlah_laki_laki' => $jumlahLakiLaki,
                'jumlah_perempuan' => $jumlahPerempuan,
                'jml_wisman_laki' => $jmlWismanLaki,
                'jml_wisman_perempuan' => $jmlWismanPerempuan,
                'kelompok' => $wisnuKunjungan,
                'wisman_by_negara' => $wismanKunjungan,
                'wisnu_event' => $wisnuEvenKunjungan,
                'wisman_event' => $wismanEvenKunjungan,
            ];
        }
    
        // Buat array untuk menyimpan data kunjungan per bulan
        $kunjungan = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();
            // Hitung total kunjungan untuk setiap kategori, filter berdasarkan wisata_id
            $totalLakiLaki = WisnuWisata::where('wisata_id', $wisata_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jumlah_laki_laki');
    
            $totalPerempuan = WisnuWisata::where('wisata_id', $wisata_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jumlah_perempuan');
    
            $totalWismanLaki = WismanWisata::where('wisata_id', $wisata_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jml_wisman_laki');
    
            $totalWismanPerempuan = WismanWisata::where('wisata_id', $wisata_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jml_wisman_perempuan');
    
            // Ambil data kunjungan
            $wisnuKunjungan = WisnuWisata::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                ->where('wisata_id', $wisata_id)
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get()
                ->groupBy('kelompok_kunjungan_id');
    
            $wismanKunjungan = WismanWisata::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                ->where('wisata_id', $wisata_id)
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get()
                ->groupBy('wismannegara_id');
    
            // Ambil data kunjungan event
            $wisnuEvenKunjungan = WisnuEvent::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                ->whereIn('event_calendar_id', $event_calendar_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->get()
                ->groupBy('kelompok_kunjungan_id');
    
            $wismanEvenKunjungan = WismanEvent::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                ->whereIn('event_calendar_id', $event_calendar_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->get()
                ->groupBy('wismannegara_id');
    
            // Gabungkan data kunjungan
            if (empty($event_calendar_id)) {
                $wisnuGabungKunjungan = DB::table('wisnuwisata')
                    ->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                    ->where('wisata_id', $wisata_id)
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->get()
                    ->groupBy('kelompok_kunjungan_id');
    
                $wismanGabungKunjungan = DB::table('wismanwisata')
                    ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                    ->where('wisata_id', $wisata_id)
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->get()
                    ->groupBy('wismannegara_id');
            } else {
                $wisnuGabungKunjungan = DB::table(function ($query) use ($startDate, $endDate, $event_calendar_id, $wisata_id) {
                    $query->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                        ->from('wisnuwisata')
                        ->where('wisata_id', $wisata_id)
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->unionAll(
                            DB::table('wisnu_event')
                                ->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                                ->whereIn('event_calendar_id', $event_calendar_id)
                                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        );
                })->get()->groupBy('kelompok_kunjungan_id');
    
                $wismanGabungKunjungan = DB::table(function ($query) use ($startDate, $endDate, $event_calendar_id, $wisata_id) {
                    $query->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                        ->from('wismanwisata')
                        ->where('wisata_id', $wisata_id)
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->unionAll(
                            DB::table('wisman_event')
                                ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                                ->whereIn('event_calendar_id', $event_calendar_id)
                                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        );
                })->get()->groupBy('wismannegara_id');
            }
    
            $WisnuEvenLakiLaki = $wisnuEvenKunjungan->flatMap(fn($group) => $group->pluck('jumlah_laki_laki'))->sum();
            $WismanEvenLakiLaki = $wismanEvenKunjungan->flatMap(fn($group) => $group->pluck('jml_wisman_laki'))->sum();
            $WisnuEvenPerempuan = $wisnuEvenKunjungan->flatMap(fn($group) => $group->pluck('jumlah_perempuan'))->sum();
            $WismanEvenPerempuan = $wismanEvenKunjungan->flatMap(fn($group) => $group->pluck('jml_wisman_perempuan'))->sum();
            $Gabungantotal_laki_laki = $WisnuEvenLakiLaki + $totalLakiLaki;
            $Gabungantotal_perempuan = $totalPerempuan + $WisnuEvenPerempuan;
            $Gabungantotal_wisman_laki = $totalWismanLaki + $WismanEvenLakiLaki;
            $Gabungantotal_wisman_perempuan = $totalWismanPerempuan + $WismanEvenPerempuan;
            $Gabunganjumlah_laki_laki = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki')) + $WisnuEvenLakiLaki;
            $Gabunganjumlah_perempuan = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan')) + $WisnuEvenPerempuan;
    
            // Simpan data kunjungan per bulan ke dalam array
            $kunjungan[$month] = [
                'total_laki_laki' => $Gabungantotal_laki_laki,
                'total_perempuan' => $Gabungantotal_perempuan,
                'total_wisman_laki' => $Gabungantotal_wisman_laki,
                'total_wisman_perempuan' => $Gabungantotal_wisman_perempuan,
                'jumlah_laki_laki' => $Gabunganjumlah_laki_laki,
                'jumlah_perempuan' => $Gabunganjumlah_perempuan,
                'kelompok' => $wisnuGabungKunjungan,
                'jml_wisman_laki' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_laki')) + $WismanEvenLakiLaki,
                'jml_wisman_perempuan' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_perempuan')) + $WismanEvenPerempuan,
                'wisman_by_negara' => $wismanGabungKunjungan,
            ];
        }
    
        // Ambil data kelompok kunjungan dan negara wisatawan
        $kelompok = KelompokKunjungan::all();
        $wismannegara = WismanNegara::all();
    
        // Hitung total keseluruhan per tahun dari semua data
        $totalKeseluruhan = [
            'total_laki_laki' => array_sum(array_column($kunjungan, 'total_laki_laki')),
            'total_perempuan' => array_sum(array_column($kunjungan, 'total_perempuan')),
            'total_wisman_laki' => array_sum(array_column($kunjungan, 'total_wisman_laki')),
            'total_wisman_perempuan' => array_sum(array_column($kunjungan, 'total_wisman_perempuan')),
        ];
    
        // Ambil nama bulan dan total kunjungan per bulan
        $bulan = [];
        $totalKunjungan = [];
    
        foreach ($kunjungan as $month => $dataBulan) {
            $bulan[] = \Carbon\Carbon::createFromFormat('!m', $month)->format('F');  // Nama bulan
            $totalKunjungan[] = $dataBulan['total_laki_laki'] + $dataBulan['total_perempuan'] + 
                                $dataBulan['total_wisman_laki'] + $dataBulan['total_wisman_perempuan'];  // Total kunjungan
        }
    
        // Hitung jumlah per kelompok
        $kelompokData = [];
        foreach ($kelompok as $kelompokItem) {
            $kelompokData[] = [
                'name' => $kelompokItem->kelompokkunjungan_name,
                'value' => collect($kunjungan)->sum(function ($dataBulan) use ($kelompokItem) {
                    return $dataBulan['kelompok']->get($kelompokItem->id, collect())->sum(function ($item) {
                        return $item->jumlah_laki_laki + $item->jumlah_perempuan;
                    });
                }),
            ];
        }
    
        $negaraData = [];
        foreach ($wismannegara as $negara) {
            $negaraData[] = [
                'name' => $negara->wismannegara_name,
                'value' => collect($kunjungan)->sum(function ($dataBulan) use ($negara) {
                    return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum(function ($item) {
                        return $item->jml_wisman_laki + $item->jml_wisman_perempuan;
                    });
                })
            ];
        }
    
        return response()->json([
            'bulan' => $bulan,
            'kunjungan' => $kunjungan,
            'kelompok' => $kelompok,
            'kelompokData' => $kelompokData,
            'wismannegara' => $wismannegara,
            'totalKeseluruhan' => $totalKeseluruhan,
            'totalKunjungan' => $totalKunjungan,
            'negaraData' => $negaraData,
        ]);
    }

    public function createWisnu()
{
    $company_id = auth()->user()->company->id;

    // Ambil hanya kolom yang diperlukan dari model Wisata
       // Ambil hanya kolom yang diperlukan dari model Wisata
       $wisata = Wisata::where('company_id', $company_id)
       ->select(['id', 'namawisata'])  // Pilih hanya kolom yang diperlukan
       ->without('photos')  // Pastikan 'photos' tidak dimuat
       ->first();

    // Ambil hanya kolom yang diperlukan dari KelompokKunjungan
    $kelompok = KelompokKunjungan::all();

    // Ambil hanya kolom yang diperlukan dari WismanNegara
    $wismannegara = WismanNegara::all();

    // Mendapatkan tanggal saat ini
    $tanggal = now()->format('d-m-Y');

    // Kembalikan data dalam format JSON
    return response()->json([
        'wisata' => $wisata,
        'kelompok' => $kelompok,
        'wismannegara' => $wismannegara,
        'tanggal' => $tanggal,
    ]);
}

public function storewisnu(Request $request)
{
      // Validasi input
      $request->validate([
        'wisata_id' => 'required|exists:wisatas,id',
        'kelompok_kunjungan_id' => 'required|array',
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'tanggal_kunjungan' => 'required|date',
        'wismannegara_id' => 'nullable|array',
        'jml_wisman_laki' => 'nullable|array',
        'jml_wisman_perempuan' => 'nullable|array',
    ]);
        // Periksa data yang sudah ada
        $existingWisnu = WisnuWisata::where('wisata_id', $request->wisata_id)
        ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->first();

        if ($existingWisnu) {
        return response()->json([
            'message' => 'Data kunjungan pada tanggal tersebut sudah ada.',
        ], 400);
        }

    try {
      
       
        // Simpan data WISNU
        foreach ($request->kelompok_kunjungan_id as  $index => $kelompok) {
            $jumlah_laki = $request->jumlah_laki_laki[$index] ?? 0;
            $jumlah_perempuan = $request->jumlah_perempuan[$index] ?? 0;

            WisnuWisata::create([
                'wisata_id' => $request->wisata_id,
                'kelompok_kunjungan_id' => $kelompok,
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }

        // Simpan data WISMAN jika ada
        if ($request->filled('wismannegara_id')) {
            foreach ($request->wismannegara_id as $index => $negara) {
                $jml_wisman_laki = $request->jml_wisman_laki[$index] ?? 0;
                $jml_wisman_perempuan = $request->jml_wisman_perempuan[$index] ?? 0;

                WismanWisata::create([
                    'wisata_id' => $request->wisata_id,
                    'wismannegara_id' => $negara,
                    'jml_wisman_laki' => $jml_wisman_laki,
                    'jml_wisman_perempuan' => $jml_wisman_perempuan,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                ]);
            }
        }

        return response()->json([
            'message' => 'Data kunjungan berhasil disimpan.',
        ], 201);

    } catch (\Exception $e) {
        // Tangani jika terjadi kesalahan lainnya
        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan data.',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], 500);
    }
}




}
