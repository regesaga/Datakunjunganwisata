<?php

namespace App\Http\Controllers\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Evencalender;
use App\Models\WisnuKuliner;
use App\Models\WisnuEvent;
use App\Models\KelompokKunjungan;
use App\Models\WismanKuliner;
use App\Models\WismanEvent;
use App\Models\WismanNegara;
use App\Models\Kuliner;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;


class KunjunganKulinerController extends Controller
{
  
    
            public function dashboard(Request $request)
            {
                $company_id = auth()->user()->company->id;
                $kuliner = Kuliner::where('company_id', $company_id)->first(); // Mendapatkan kuliner terkait
                $hash = new Hashids();
            
                if (!$kuliner) {
                    return redirect()->back()->with('error', 'Kuliner tidak ditemukan untuk perusahaan Anda.');
                }
            
                $kuliner_id = $kuliner->id; // Dapatkan kuliner_id untuk filtering data
            
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
                
                    // Ambil data Wisnu Kuliner
                    $wisnuKunjungan = WisnuKuliner::where('kuliner_id', $kuliner_id)
                        ->whereDate('tanggal_kunjungan', $tanggal)
                        ->get()
                        ->groupBy('kelompok_kunjungan_id');
                
                    // Ambil data Wisman Kuliner
                    $wismanKunjungan = WismanKuliner::where('kuliner_id', $kuliner_id)
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
                
                    // Hitung total harian dari Wisnu Kuliner dan Wisnu Event
                    $jumlahLakiLaki = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki')) + $wisnuEvenKunjungan->flatMap(fn($group) => $group->pluck('jumlah_laki_laki'))->sum();
                    $jumlahPerempuan = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan')) + $wisnuEvenKunjungan->flatMap(fn($group) => $group->pluck('jumlah_perempuan'))->sum();
                    
                    // Hitung total harian dari Wisman Kuliner dan Wisman Event
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
            
                    // Hitung total kunjungan untuk setiap kategori, filter berdasarkan kuliner_id
                    $totalLakiLaki = WisnuKuliner::where('kuliner_id', $kuliner_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_laki_laki');
            
                    $totalPerempuan = WisnuKuliner::where('kuliner_id', $kuliner_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_perempuan');
            
                    $totalWismanLaki = WismanKuliner::where('kuliner_id', $kuliner_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_laki');
            
                    $totalWismanPerempuan = WismanKuliner::where('kuliner_id', $kuliner_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_perempuan');
            
                    // Ambil data kunjungan
                    $wisnuKunjungan = WisnuKuliner::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                        ->where('kuliner_id', $kuliner_id)
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->get()
                        ->groupBy('kelompok_kunjungan_id');
            
                    $wismanKunjungan = WismanKuliner::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                        ->where('kuliner_id', $kuliner_id)
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->get()
                        ->groupBy('wismannegara_id');
            

                        
                    
                                                             // Ambil data kunjungan
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

                                                             if (empty($event_calendar_id)) {
                                                                // If no events are found, execute only the part for 'wisnukuliner' and 'wismankuliner'
                                                                $wisnuGabungKunjungan = DB::table('wisnukuliner')
                                                                    ->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                                                                    ->where('kuliner_id', $kuliner_id)
                                                                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                                                                    ->get()
                                                                    ->groupBy('kelompok_kunjungan_id');
                                                            
                                                                $wismanGabungKunjungan = DB::table('wismankuliner')
                                                                    ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                                                                    ->where('kuliner_id', $kuliner_id)
                                                                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                                                                    ->get()
                                                                    ->groupBy('wismannegara_id');
                                                            } else {
                                                                // If there are event_calendar_ids, proceed with the unionAll
                                                                $wisnuGabungKunjungan =  DB::table(function ($query) use ($startDate, $endDate,$event_calendar_id, $kuliner_id) {
                                                                    $query->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                                                                        ->from('wisnukuliner')
                                                                        ->where('kuliner_id', $kuliner_id)
                                                                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                                                                        ->unionAll(
                                                                            DB::table('wisnu_event')
                                                                                ->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                                                                                ->whereIn('event_calendar_id', $event_calendar_id)
                                                                                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                                                                        );
                                                                })->get()->groupBy('kelompok_kunjungan_id');
                                                            
                                                                $wismanGabungKunjungan =  DB::table(function ($query) use ($startDate, $endDate, $event_calendar_id, $kuliner_id) {
                                                                    $query->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                                                                        ->from('wismankuliner')
                                                                        ->where('kuliner_id', $kuliner_id)
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
                                $WismanEvenLakiLaki =$wismanEvenKunjungan->flatMap(fn($group) => $group->pluck('jml_wisman_laki'))->sum();
                                $WisnuEvenPerempuan =$wisnuEvenKunjungan->flatMap(fn($group) => $group->pluck('jumlah_perempuan'))->sum();
                                $WismanEvenPerempuan =$wismanEvenKunjungan->flatMap(fn($group) => $group->pluck('jml_wisman_perempuan'))->sum();
                                $totalEvenLakiLaki = $WisnuEvenLakiLaki + $WismanEvenLakiLaki ;
                                $totalEvenPerempuan = $WisnuEvenPerempuan + $WismanEvenPerempuan ;
                                $totalEvenPengunjung = $totalEvenLakiLaki + $totalEvenPerempuan ;
                    


                    $Gabungantotal_laki_laki = $WisnuEvenLakiLaki + $totalLakiLaki;
                    $Gabungantotal_perempuan = $totalPerempuan + $WisnuEvenPerempuan;
                    $Gabungantotal_wisman_laki = $totalWismanLaki + $WismanEvenLakiLaki;
                    $Gabungantotal_wisman_perempuan = $totalWismanPerempuan + $WismanEvenPerempuan;
                    $Gabunganjumlah_laki_laki = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki')) + $WisnuEvenLakiLaki;
                    $Gabunganjumlah_perempuan = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan')) + $WisnuEvenPerempuan;
                    $Gabungankelompok = $wisnuGabungKunjungan;
                    $Gabunganjml_wisman_laki = $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_laki')) + $WismanEvenLakiLaki;
                    $Gabunganjml_wisman_perempuan =$wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_perempuan')) + $WismanEvenPerempuan;
                    $Gabunganwisman_by_negara = $wismanGabungKunjungan;


                                     
                    // Simpan data kunjungan per bulan ke dalam array
                    $kunjungan[$month] = [
                        'total_laki_laki' => $Gabungantotal_laki_laki,
                        'total_perempuan' => $Gabungantotal_perempuan,
                        'total_wisman_laki' => $Gabungantotal_wisman_laki,
                        'total_wisman_perempuan' => $Gabungantotal_wisman_perempuan,
                        'jumlah_laki_laki' => $Gabunganjumlah_laki_laki,
                        'jumlah_perempuan' =>  $Gabunganjumlah_perempuan,
                        'kelompok' => $Gabungankelompok,
                        'jml_wisman_laki' =>  $Gabunganjml_wisman_laki,
                        'jml_wisman_perempuan' => $Gabunganjml_wisman_perempuan,
                        'wisman_by_negara' => $Gabunganwisman_by_negara,
                    ];
                }
            
                // Ambil data kelompok kunjungan dan negara kulinerwan
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
                    $totalKunjunganLaki[] = $dataBulan['total_laki_laki'] + $dataBulan['total_wisman_laki'] ;  // Total  LakiLaki
                    $totalKunjunganPerempuan[] = $dataBulan['total_perempuan'] + $dataBulan['total_wisman_perempuan'] ;  // Total  LakiLaki
                }
                // Hitung jumlah per kelompok
                $kelompokData = [];
                foreach ($kelompok as $kelompokItem) {
                    $kelompokData[] = [
                        'name' => $kelompokItem->kelompokkunjungan_name,
                        'value' => collect($kunjungan)->sum(function ($dataBulan) use ($kelompokItem) {
                            return $dataBulan['kelompok']->get($kelompokItem->id, collect())->sum(function ($item) {
                                // Gunakan properti objek alih-alih array
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
                                // Gunakan properti objek
                                return $item->jml_wisman_laki + $item->jml_wisman_perempuan;
                            });
                        })
                    ];
                }
                
                    $eventStatistics = [];

                    $totalKeseluruhanEven = [
                        'total_laki_laki' => 0,
                        'total_perempuan' => 0,
                        'total_wisman_laki' => 0,
                        'total_wisman_perempuan' => 0,
                        'total_pengunjung' => 0
                    ];
                    
                    if (!$events->isEmpty()) {
                        foreach ($events as $event) {
                            $event_calendar_id = $event->id;
                    
                            // Menghitung jumlah pengunjung laki-laki dan perempuan untuk WisnuEvent dan WismanEvent
                            $totalEvenWisnuLaki = WisnuEvent::where('event_calendar_id', $event_calendar_id)
                                ->whereYear('tanggal_kunjungan', $year)
                                ->sum('jumlah_laki_laki');
                    
                            $totalEvenWisnuPerempuan = WisnuEvent::where('event_calendar_id', $event_calendar_id)
                                ->whereYear('tanggal_kunjungan', $year)
                                ->sum('jumlah_perempuan');
                    
                            $totalEvenWismanLaki = WismanEvent::where('event_calendar_id', $event_calendar_id)
                                ->whereYear('tanggal_kunjungan', $year)
                                ->sum('jml_wisman_laki');
                    
                            $totalEvenWismanPerempuan = WismanEvent::where('event_calendar_id', $event_calendar_id)
                                ->whereYear('tanggal_kunjungan', $year)
                                ->sum('jml_wisman_perempuan');
                    
                            // Menjumlahkan seluruh pengunjung untuk setiap kategori
                            $totalLakiLaki = $totalEvenWisnuLaki + $totalEvenWismanLaki; 
                            $totalPerempuan = $totalEvenWisnuPerempuan + $totalEvenWismanPerempuan; 
                            $totalPengunjung = $totalLakiLaki + $totalPerempuan;
                    
                            // Menambahkan hasil ke total keseluruhan
                            $totalKeseluruhanEven['total_laki_laki'] += $totalLakiLaki;
                            $totalKeseluruhanEven['total_perempuan'] += $totalPerempuan;
                            $totalKeseluruhanEven['total_wisman_laki'] += $totalEvenWismanLaki;
                            $totalKeseluruhanEven['total_wisman_perempuan'] += $totalEvenWismanPerempuan;
                            $totalKeseluruhanEven['total_pengunjung'] += $totalPengunjung;
                    
                            // Menyimpan statistik per event (untuk kebutuhan jika ingin menampilkan per event)
                            $eventStatistics[$event->id] = [
                                'event_name' => $event->name,
                                'total_evenwisnu_laki' => $totalEvenWisnuLaki,
                                'total_evenwisnu_perempuan' => $totalEvenWisnuPerempuan,
                                'total_evenwisman_laki' => $totalEvenWismanLaki,
                                'total_evenwisman_perempuan' => $totalEvenWismanPerempuan,
                                'total_evenkunjungan' => $totalPengunjung,
                                'total_laki_laki' => $totalLakiLaki, // Pengunjung Laki-laki
                                'total_perempuan' => $totalPerempuan, // Pengunjung Perempuan
                            ];
                        }
                    }
    

                    return view('account.kuliner.kunjungankuliner.dashboard', compact('bulan',
                        'kunjungan', 'kelompok','kelompokData','wismannegara', 'kuliner','bytgl','eventStatistics', 'events',
                        'hash', 'year', 'totalKeseluruhan','totalKeseluruhanEven','bulan', 'totalKunjungan','totalKunjunganLaki','totalKunjunganPerempuan', 'negaraData'
                    ));
            }

            // Menampilkan form input kunjungan
public function createwisnu()
{
    $company_id = auth()->user()->company->id;
    $kelompok = KelompokKunjungan::all();
    $kuliner = Kuliner::where('company_id', $company_id)->first();
    $wismannegara = WismanNegara::all();

    // Define the $tanggal variable, you can set it to the current date or any other logic
    $tanggal = now()->format('d-m-Y'); // This sets $tanggal to today's date in Y-m-d format

    return view('account.kuliner.kunjungankuliner.create', compact('kuliner', 'kelompok', 'wismannegara', 'tanggal'));
}

// Menyimpan data kunjungan
public function storewisnu(Request $request)
{
    // Validasi input
    $request->validate([
        'kuliner_id' => 'required',
        'tanggal_kunjungan' => 'required|date',
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'jumlah_laki_laki.*' => 'required|integer|min:0',
        'jumlah_perempuan.*' => 'required|integer|min:0',
        'wismannegara_id' => 'array',
        'jml_wisman_laki' => 'array',
        'jml_wisman_perempuan' => 'array',
        'jml_wisman_laki.*' => 'integer|min:0',
        'jml_wisman_perempuan.*' => 'integer|min:0',
    ]);

    // Cek apakah tanggal sudah ada di database
    $existingWisnu = WisnuKuliner::where('kuliner_id', $request->kuliner_id)
        ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->first();

    if ($existingWisnu) {
        // Jika ada, buat notifikasi untuk mengonfirmasi apakah akan mengubah data
        $formattedDate = Carbon::parse($request->tanggal_kunjungan)->format('d-m-Y');
        return redirect()->back()->with('warning', 'Data Kunjungan dengan Tanggal "' . $formattedDate . '" Sudah Di Input. Pilih Tanggal Lain atau Ubah data di menu')
            ->withInput();
    }

    try {
        // Loop untuk data WISNU (Kulinerwan Nusantara)
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuKuliner::create([
                'kuliner_id' => $request->kuliner_id,
                'kelompok_kunjungan_id' => $kelompok, 
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }

        // Loop untuk data WISMAN (Kulinerwan Mancanegara) hanya jika data tersedia
        if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
            foreach ($request->wismannegara_id as $index => $negara) {
                $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
                WismanKuliner::create([
                    'kuliner_id' => $request->kuliner_id,
                    'wismannegara_id' => $negara,
                    'jml_wisman_laki' => $jumlah_wisman_laki,
                    'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data kunjungan berhasil disimpan.');
    } catch (\Exception $e) {
        // Log error
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'Gagal menyimpan data kunjungan. Silakan coba lagi.');
    }
}

// Menampilkan form edit kunjungan
public function editwisnu($kuliner_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    // Dekripsi `kuliner_id`
    $kuliner_id = $hash->decode($kuliner_id)[0] ?? null;

    if (!$kuliner_id) {
        abort(404); // Jika `kuliner_id` tidak valid, return 404
    }

    $company_id = auth()->user()->company->id;
    $kuliner = Kuliner::where('company_id', $company_id)->first();
    $wisnuData = WisnuKuliner::where('kuliner_id', $kuliner_id)
    ->where('tanggal_kunjungan', $tanggal_kunjungan)
    ->with('kelompokkunjungan')
    ->get();

    $wismanData = WismanKuliner::where('kuliner_id', $kuliner_id)
      ->where('tanggal_kunjungan', $tanggal_kunjungan)
      ->with('wismannegara')
      ->get();
    // Aggregate the data for WISMAN based on wismannegara_id
    $aggregatedWismanData = $wismanData->groupBy('wismannegara_id')->map(function($group) {
        return [
            'wismannegara_id' => $group->first()->wismannegara_id,
            'jml_wisman_laki' => $group->sum('jml_wisman_laki'),
            'jml_wisman_perempuan' => $group->sum('jml_wisman_perempuan'),
        ];
    });

     // Aggregate the data for WISNU based on kelompok_kunjungan_id
     $aggregatedWisnuData = $wisnuData->groupBy('kelompok_kunjungan_id')->map(function($group) {
        return [
            'kelompok_kunjungan_id' => $group->first()->kelompok_kunjungan_id,
            'kelompok_kunjungan_name' => optional($group->first()->kelompokkunjungan)->kelompokkunjungan_name,
            'jumlah_laki_laki' => $group->sum('jumlah_laki_laki'),
            'jumlah_perempuan' => $group->sum('jumlah_perempuan'),
        ];
    }); 

    // Get other data
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();

    // Pass data to the view
    return view('account.kuliner.kunjungankuliner.edit', compact('wisnuData', 'hash','aggregatedWismanData','aggregatedWisnuData','tanggal_kunjungan','wismanData', 'kuliner', 'kelompok', 'wismannegara', 'hash'));
}

public function updatewisnu(Request $request, $tanggal_kunjungan)
{
    $hash = new Hashids();

    // Decode kuliner_id yang dikirim
    $kuliner_id_decoded = $hash->decode($request->kuliner_id);
    if (empty($kuliner_id_decoded)) {
        return redirect()->back()->with('error', 'ID kuliner tidak valid.')->withInput($request->all());
    }
    $decodedKulinerId = $kuliner_id_decoded[0];

    // Validasi input
    $request->validate([
        'kuliner_id' => 'required', // Validasi kuliner_id sebagai parameter
        'tanggal_kunjungan' => 'required|date', 
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'jumlah_laki_laki.*' => 'required|integer|min:0',
        'jumlah_perempuan.*' => 'required|integer|min:0',
        'wismannegara_id' => 'array',
        'jml_wisman_laki' => 'array',
        'jml_wisman_perempuan' => 'array',
        'jml_wisman_laki.*' => 'integer|min:0',
        'jml_wisman_perempuan.*' => 'integer|min:0',
    ]);

    // Mulai transaksi
    DB::beginTransaction();
    Log::info('Starting updatewisnu method', ['tanggal_kunjungan' => $tanggal_kunjungan]);

    try {
        // Hapus data sebelumnya berdasarkan decoded kuliner_id dan tanggal kunjungan
        $deletedWisnu = WisnuKuliner::where('kuliner_id', $decodedKulinerId)
                                     ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanKuliner::where('kuliner_id', $decodedKulinerId)
                                       ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                       ->delete();

        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Loop untuk data WISNU
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuKuliner::create([
                'kuliner_id' => $decodedKulinerId,
                'kelompok_kunjungan_id' => $kelompok,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'updated_at' => now(),
            ]);
        }

       // Loop untuk data WISMAN (Kulinerwan Mancanegara) hanya jika data tersedia
       if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
        foreach ($request->wismannegara_id as $index => $negara) {
            $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
            $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
            WismanKuliner::create([
                'kuliner_id' => $decodedKulinerId,
                'wismannegara_id' => $negara,
                'jml_wisman_laki' => $jumlah_wisman_laki,
                'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }
    }

        // Commit transaksi
        DB::commit();
        
        // Alihkan ke halaman index dengan pesan sukses
        return redirect()->route('account.kuliner.kunjungankuliner.indexkunjungankulinerpertahun')->with('success', 'Data kunjungan berhasil diperbarui.');

    } catch (\Exception $e) {
        DB::rollBack();

        // Mencatat detail kesalahan dengan data yang akan disimpan
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString(),
            'decoded_kuliner_id' => $decodedKulinerId,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jumlah_laki_laki' => $request->jumlah_laki_laki,
            'jumlah_perempuan' => $request->jumlah_perempuan,
            'wismannegara_id' => $request->wismannegara_id,
            'jml_wisman_laki' => $request->jml_wisman_laki,
            'jml_wisman_perempuan' => $request->jml_wisman_perempuan,
        ]);

        return redirect()->back()->with('error', 'Gagal menyimpan data kunjungan. Silakan coba lagi. Kesalahan: ' . $e->getMessage())
                                 ->withInput($request->all());
    }
}


// Fungsi untuk menghapus data kunjungan
public function deletewisnu($kuliner_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    
    // Dekripsi `kuliner_id`
    $kuliner_id = $hash->decode($kuliner_id)[0] ?? null;

    if (!$kuliner_id) {
        abort(404); // Jika `kuliner_id` tidak valid, return 404
    }

    try {
        // Mulai transaksi
        DB::beginTransaction();
        
        // Hapus data WISNU berdasarkan kuliner_id dan tanggal_kunjungan
        $deletedWisnu = WisnuKuliner::where('kuliner_id', $kuliner_id)
                                    ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                    ->delete();

        // Hapus data WISMAN berdasarkan kuliner_id dan tanggal_kunjungan
        $deletedWisman = WismanKuliner::where('kuliner_id', $kuliner_id)
                                      ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                      ->delete();

        // Log jumlah data yang dihapus
        Log::info('Deleted WISNU and WISMAN data', [
            'kuliner_id' => $kuliner_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Commit transaksi
        DB::commit();

        return redirect()->route('account.kuliner.kunjungankuliner.index')
                         ->with('success', 'Data kunjungan berhasil dihapus.');
    } catch (\Exception $e) {
        // Rollback transaksi jika ada kesalahan
        DB::rollBack();

        // Log error
        Log::error('Failed to delete kunjungan data.', [
            'error_message' => $e->getMessage(),
            'kuliner_id' => $kuliner_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->route('account.kuliner.kunjungankuliner.index')
                         ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
    }
}
public function indexkunjungankuliner(Request $request)
{
    $hash = new Hashids();
    $company_id = auth()->user()->company->id;

    // Ambil data Kuliner berdasarkan company_id
    $kuliner = Kuliner::where('company_id', $company_id)->first();
    
    if (!$kuliner) {
        return redirect()->back()->withErrors(['error' => 'Kuliner tidak ditemukan untuk pengguna ini.']);
    }

    $kuliner_id = $kuliner->id; // Mendapatkan kuliner_id dari data Kuliner

      // Menentukan bulan dalam format angka
      $bulan = $request->input('bulan', date('m')); 
      $tahun = $request->input('tahun', date('Y')); 

      // Daftar bulan dalam Bahasa Indonesia
      $bulanIndo = [
          1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
          7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
      ];

      // Mendapatkan nama bulan
      $namaBulan = $bulanIndo[(int)$bulan];

    // Periode waktu untuk bulan yang dipilih
    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();

    // Buat rentang tanggal dari startDate hingga endDate
    $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);

    // Ambil data WisnuKuliner berdasarkan kuliner_id
    $wisnuKunjungan = WisnuKuliner::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
        ->where('kuliner_id', $kuliner_id) // Filter berdasarkan kuliner_id
        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
        ->get()
        ->groupBy('tanggal_kunjungan');

    // Ambil data WismanKuliner berdasarkan kuliner_id
    $wismanKunjungan = WismanKuliner::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
        ->where('kuliner_id', $kuliner_id) // Filter berdasarkan kuliner_id
        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
        ->get()
        ->groupBy('tanggal_kunjungan');

    // Olah data kunjungan
    $kunjungan = [];
    foreach ($tanggalRentang as $tanggal) {
        $tanggalFormat = $tanggal->format('Y-m-d');

        // Ambil data kunjungan dari WisnuKuliner
        $dataWisnu = $wisnuKunjungan->get($tanggalFormat, collect());
        $jumlahLakiLaki = $dataWisnu->sum('jumlah_laki_laki');
        $jumlahPerempuan = $dataWisnu->sum('jumlah_perempuan');
        $wisnuByKelompok = $dataWisnu->groupBy('kelompok_kunjungan_id');

        // Ambil data kunjungan dari WismanKuliner
        $dataWisman = $wismanKunjungan->get($tanggalFormat, collect());
        $jmlWismanLaki = $dataWisman->sum('jml_wisman_laki');
        $jmlWismanPerempuan = $dataWisman->sum('jml_wisman_perempuan');
        $wismanByNegara = $dataWisman->groupBy('wismannegara_id');

        $kunjungan[$tanggalFormat] = [
            'jumlah_laki_laki' => $jumlahLakiLaki ?: 0,
            'jumlah_perempuan' => $jumlahPerempuan ?: 0,
            'kelompok' => $wisnuByKelompok,
            'jml_wisman_laki' => $jmlWismanLaki ?: 0,
            'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
            'wisman_by_negara' => $wismanByNegara,
        ];
    }

    // Sort data berdasarkan tanggal
    $kunjungan = collect($kunjungan)->sortBy(function ($item, $key) {
        return $key;
    });

    // Ambil data pendukung
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();
    return view('account.kuliner.kunjungankuliner.index', compact(
        'kunjungan', 'kuliner', 'kelompok', 'wismannegara', 'hash', 'bulan', 'tahun','bulanIndo'
    ));
}

    
public function indexkunjungankulinerpertahun(Request $request)
{
    $hash = new Hashids();
    $company_id = auth()->user()->company->id;
    $kuliner = Kuliner::where('company_id', $company_id)->first();

    if (!$kuliner) {
        return redirect()->back()->with('error', 'Kuliner tidak ditemukan.');
    }
    $kuliner_id = $kuliner->id; // Dapatkan kuliner_id untuk filtering data
    // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
    $tahun = $request->input('tahun', date('Y'));

        
     $bytgl = [];
     $totalLakiLaki = 0;
     $totalPerempuan = 0;
     $totalWismanLaki = 0;
     $totalWismanPerempuan = 0;
     $totalKunjungan = 0;
     $awal = Carbon::createFromFormat('Y-m-d', "$tahun-01-01");
     $akhir = Carbon::createFromFormat('Y-m-d', "$tahun-12-31");
     
     for ($date = $awal; $date <= $akhir; $date->addDay()) {
         $tanggal = $date->format('Y-m-d');
     
         // Ambil data Wisnu
         $wisnuKunjungan = WisnuKuliner::where('kuliner_id', $kuliner_id)
             ->whereDate('tanggal_kunjungan', $tanggal)
             ->get()
             ->groupBy('kelompok_kunjungan_id');
     
         // Ambil data Wisman
         $wismanKunjungan = WismanKuliner::where('kuliner_id', $kuliner_id)
             ->whereDate('tanggal_kunjungan', $tanggal)
             ->get()
             ->groupBy('wismannegara_id');
     
         // Hitung total harian
         $jumlahLakiLaki = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki'));
         $jumlahPerempuan = $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan'));
         $jmlWismanLaki = $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_laki'));
         $jmlWismanPerempuan = $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_perempuan'));
     
         // Tambahkan ke total keseluruhan
         $totalLakiLaki += $jumlahLakiLaki;
         $totalPerempuan += $jumlahPerempuan;
         $totalWismanLaki += $jmlWismanLaki;
         $totalWismanPerempuan += $jmlWismanPerempuan;
         $totalKunjungan= $totalLakiLaki + $totalPerempuan + $totalWismanLaki + $totalWismanPerempuan;
     
         // Isi data pada tanggal tertentu
         $bytgl[$tanggal] = [
             'tanggal_kunjungan' => $tanggal,
             'jumlah_laki_laki' => $jumlahLakiLaki,
             'jumlah_perempuan' => $jumlahPerempuan,
             'jml_wisman_laki' => $jmlWismanLaki,
             'jml_wisman_perempuan' => $jmlWismanPerempuan,
             'kelompok' => $wisnuKunjungan,
             'wisman_by_negara' => $wismanKunjungan,
         ];
     }

    // Buat array untuk menyimpan data kunjungan per bulan
    $kunjungan = [];

    for ($month = 1; $month <= 12; $month++) {
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$month}-01")->startOfMonth();
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$month}-01")->endOfMonth();

        // Ambil data Wisnu hanya untuk kuliner terkait
        $wisnuKunjungan = WisnuKuliner::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->where('kuliner_id', $kuliner->id)
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->get()
            ->groupBy('kelompok_kunjungan_id');

        // Ambil data Wisman hanya untuk kuliner terkait
        $wismanKunjungan = WismanKuliner::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
            ->where('kuliner_id', $kuliner->id)
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->get()
            ->groupBy('wismannegara_id');

        $kunjungan[$month] = [
            'jumlah_laki_laki' => $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki')),
            'jumlah_perempuan' => $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan')),
            'kelompok' => $wisnuKunjungan,
            'jml_wisman_laki' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_laki')),
            'jml_wisman_perempuan' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_perempuan')),
            'wisman_by_negara' => $wismanKunjungan,
        ];
    }
      // Hitung total keseluruhan per tahun dari semua data
      $totalKeseluruhan = [
        'total_laki_laki' => array_sum(array_column($kunjungan, 'total_laki_laki')),
        'total_perempuan' => array_sum(array_column($kunjungan, 'total_perempuan')),
        'total_wisman_laki' => array_sum(array_column($kunjungan, 'total_wisman_laki')),
        'total_wisman_perempuan' => array_sum(array_column($kunjungan, 'total_wisman_perempuan')),
    ];


    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();

    return view('account.kuliner.kunjungankuliner.indexkunjungankulinerpertahun', compact('kunjungan','kuliner_id', 'kuliner', 'kelompok', 'wismannegara', 'hash', 'tahun','bytgl','totalKeseluruhan', 'totalKunjungan'));
}
        public function filterbyinput(Request $request)
    {
        $company_id = auth()->user()->company->id;
        $kelompok = KelompokKunjungan::all();
        $kuliner = Kuliner::where('company_id', $company_id)->first();
        $wismannegara = WismanNegara::all();

        // Define the $tanggal variable, you can set it to the current date or any other logic
        $tanggal = now()->format('d-m-Y'); // This sets $tanggal to today's date in Y-m-d format

        return view('account.kuliner.kunjungankuliner.filterbyinput', compact('kuliner', 'kelompok', 'wismannegara', 'tanggal'));
    }

    public function filterbulan(Request $request)
    {
        $company_id = auth()->user()->company->id;
        $kuliner = Kuliner::where('company_id', $company_id)->first();
        $hash = new Hashids();
    
        // Jika kuliner tidak ditemukan, kembalikan error
        if (!$kuliner) {
            return redirect()->back()->with('error', 'Kuliner tidak ditemukan.');
        }
    
        // Ambil tahun dan bulan dari request, default ke tahun dan bulan saat ini jika tidak ada input
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
    
        // Fetch data dari database dengan filter tahun, bulan, dan kuliner_id
        $wisnuKunjungan = WisnuKuliner::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->where('kuliner_id', $kuliner->id) // Filter berdasarkan kuliner_id
            ->whereYear('tanggal_kunjungan', $year)
            ->whereMonth('tanggal_kunjungan', $month)
            ->get()
            ->groupBy('tanggal_kunjungan');
    
        $wismanKunjungan = WismanKuliner::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
            ->where('kuliner_id', $kuliner->id) // Filter berdasarkan kuliner_id
            ->whereYear('tanggal_kunjungan', $year)
            ->whereMonth('tanggal_kunjungan', $month)
            ->get()
            ->groupBy('tanggal_kunjungan');
    
        // Initialize an array to hold all visits data
        $kunjungan = [];
    
        // Populate the kunjungan array with data for each date
        foreach ($wisnuKunjungan as $tanggal => $dataTanggal) {
            // Convert to collection for easier manipulation
            $dataTanggal = collect($dataTanggal);
    
            // Get the total local visitors
            $jumlahLakiLaki = $dataTanggal->sum('jumlah_laki_laki');
            $jumlahPerempuan = $dataTanggal->sum('jumlah_perempuan');
    
            // Get the total foreign visitors, defaulting to 0 if no data exists
            $jmlWismanLaki = $wismanKunjungan->get($tanggal, collect())->sum('jml_wisman_laki');
            $jmlWismanPerempuan = $wismanKunjungan->get($tanggal, collect())->sum('jml_wisman_perempuan');
    
            // Initialize an array to hold foreign visitor counts by country
            $wismanByNegara = $wismanKunjungan->get($tanggal, collect())->groupBy('wismannegara_id');
    
            $kunjungan[$tanggal] = [
                'jumlah_laki_laki' => $jumlahLakiLaki,
                'jumlah_perempuan' => $jumlahPerempuan,
                'kelompok' => $dataTanggal, // Store the collection for later use
                'jml_wisman_laki' => $jmlWismanLaki ?: 0, // Ensure default to 0
                'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0, // Ensure default to 0
                'wisman_by_negara' => $wismanByNegara, // Store foreign visitor data by country
            ];
        }
    
        // Convert to a collection for easier manipulation in the view
        $kunjungan = collect($kunjungan);
    
        // Sort kunjungan by date (youngest to oldest)
        $kunjungan = $kunjungan->sortBy(function($item, $key) {
            return $key; // Sort by the key which is tanggal
        });
    
        // Get kelompok and wisman negara
        $kelompok = KelompokKunjungan::all();
        $wismannegara = WismanNegara::all();
    
        // Kirim year dan month ke view untuk keperluan display
        return view('account.kuliner.kunjungankuliner.filterbulan', compact('kunjungan', 'kuliner', 'kelompok', 'wismannegara', 'hash', 'year', 'month'));
    }
    
    
    public function filtertahun(Request $request)
    {
        $company_id = auth()->user()->company->id;
        $kuliner = Kuliner::where('company_id', $company_id)->first();
        $hash = new Hashids();
    
        // Pastikan ada data kuliner terkait
        if (!$kuliner) {
            return redirect()->back()->with('error', 'Kuliner tidak ditemukan untuk perusahaan Anda.');
        }
    
        $kuliner_id = $kuliner->id;
    
        // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
        $year = $request->input('year', date('Y'));
    
        // Buat array untuk menyimpan data kunjungan per bulan
        $kunjungan = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalLakiLaki = WisnuKuliner::where('kuliner_id', $kuliner_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jumlah_laki_laki');
    
            $totalPerempuan = WisnuKuliner::where('kuliner_id', $kuliner_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jumlah_perempuan');
    
            $totalWismanLaki = WismanKuliner::where('kuliner_id', $kuliner_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jml_wisman_laki');
    
            $totalWismanPerempuan = WismanKuliner::where('kuliner_id', $kuliner_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jml_wisman_perempuan');
    
            // Simpan data kunjungan per bulan ke dalam array kunjungan
            $kunjungan[$month] = [
                'total_laki_laki' => $totalLakiLaki,
                'total_perempuan' => $totalPerempuan,
                'total_wisman_laki' => $totalWismanLaki,
                'total_wisman_perempuan' => $totalWismanPerempuan,
            ];
        }
    
        // Hitung total keseluruhan per tahun dari semua data
        $totalKeseluruhan = [
            'total_laki_laki' => array_sum(array_column($kunjungan, 'total_laki_laki')),
            'total_perempuan' => array_sum(array_column($kunjungan, 'total_perempuan')),
            'total_wisman_laki' => array_sum(array_column($kunjungan, 'total_wisman_laki')),
            'total_wisman_perempuan' => array_sum(array_column($kunjungan, 'total_wisman_perempuan')),
        ];
    
        // Kirim year, kunjungan, dan totalKeseluruhan ke view untuk keperluan display
        return view('account.kuliner.kunjungankuliner.filtertahun', compact('kunjungan', 'kuliner', 'hash', 'year', 'totalKeseluruhan'));
    }
    
    

    public function filterwisnubulan(Request $request)
        {
            $hash = new Hashids();
            $company_id = auth()->user()->company->id;
            
            // Fetch kuliner based on company_id and ensure we get the kuliner_id
            $kuliner = Kuliner::where('company_id', $company_id)->first(); 
            
            // Check if kuliner is found
            if (!$kuliner) {
                return response()->json(['error' => 'Kuliner not found for this company'], 404);
            }
            
            $kuliner_id = $kuliner->id; // Get the kuliner_id
            
            // Menentukan bulan dalam format angka
            $bulan = $request->input('bulan', date('m')); 
            $tahun = $request->input('tahun', date('Y')); 

            // Daftar bulan dalam Bahasa Indonesia
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            // Mendapatkan nama bulan
            $namaBulan = $bulanIndo[(int)$bulan];

            
            // Buat rentang tanggal untuk bulan yang dipilih
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
            
            // Buat rentang tanggal dari startDate hingga endDate
            $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);
        
            // Ambil data WisnuKuliner berdasarkan kuliner_id
            $wisnuKunjungan = WisnuKuliner::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->where('kuliner_id', $kuliner_id) // Filter berdasarkan kuliner_id
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->get()
            ->groupBy('tanggal_kunjungan');


            $kunjungan = [];
            foreach ($tanggalRentang as $tanggal ) {
                $tanggalFormat = $tanggal->format('Y-m-d');

                // Ambil data kunjungan dari WisnuKuliner
                $dataWisnu = $wisnuKunjungan->get($tanggalFormat, collect());
                // Get the total local visitors
                $jumlahLakiLaki = $dataWisnu->sum('jumlah_laki_laki');
                $jumlahPerempuan = $dataWisnu->sum('jumlah_perempuan');
            
                $kunjungan[$tanggalFormat] = [
                    'jumlah_laki_laki' => $jumlahLakiLaki,
                    'jumlah_perempuan' => $jumlahPerempuan,
                    'kelompok' => $dataWisnu, // Store the collection for later use
                ];
            }
            
            // Sort kunjungan by date (youngest to oldest)
            $kunjungan = collect($kunjungan)->sortBy(function($item, $key) {
                return $key; // Sort by the key which is tanggal
            });

            // Get kelompok and wisman negara
            $kelompok = KelompokKunjungan::all();
            
            return view('account.kuliner.kunjungankuliner.filterwisnubulan', compact('kunjungan','kuliner','kelompok', 'hash', 'bulan', 'tahun','bulanIndo'));
        }

public function filterwismanbulan(Request $request)
{
    $hash = new Hashids();
    $company_id = auth()->user()->company->id;
    
    // Fetch kuliner based on company_id and ensure we get the kuliner_id
    $kuliner = Kuliner::where('company_id', $company_id)->first(); 
    
    // Check if kuliner is found
    if (!$kuliner) {
        return response()->json(['error' => 'Kuliner not found for this company'], 404);
    }
    
    $kuliner_id = $kuliner->id; // Get the kuliner_id
    
      // Menentukan bulan dalam format angka
      $bulan = $request->input('bulan', date('m')); 
      $tahun = $request->input('tahun', date('Y')); 
  
      // Daftar bulan dalam Bahasa Indonesia
      $bulanIndo = [
          1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
          7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
      ];
    
    // Buat rentang tanggal untuk bulan yang dipilih
    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();

     // Buat rentang tanggal dari startDate hingga endDate
     $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);
    
    // Ambil data WismanKuliner berdasarkan kuliner_id
    $wismanKunjungan = WismanKuliner::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
    ->where('kuliner_id', $kuliner_id) // Filter berdasarkan kuliner_id
    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
    ->get()
    ->groupBy('tanggal_kunjungan');


    $kunjungan = [];
    foreach ($tanggalRentang as $tanggal) {
        $tanggalFormat = $tanggal->format('Y-m-d');
        // Ambil data kunjungan dari WisnuKuliner

        // Ambil data kunjungan dari WismanKuliner
        $dataWisman = $wismanKunjungan->get($tanggalFormat, collect());
        $jmlWismanLaki = $dataWisman->sum('jml_wisman_laki');
        $jmlWismanPerempuan = $dataWisman->sum('jml_wisman_perempuan');
        $wismanByNegara = $dataWisman->groupBy('wismannegara_id');
    
        $kunjungan[$tanggalFormat] = [
            'jml_wisman_laki' => $jmlWismanLaki ?: 0, // Ensure default to 0
            'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0, // Ensure default to 0
            'wisman_by_negara' => $wismanByNegara, // Store foreign visitor data by country
        ];
    }
    
    $kunjungan = collect($kunjungan)->sortBy(function($item, $key) {
        return $key;
    });

    // Get wisman negara (foreign countries)
    $wismannegara = WismanNegara::all();
    
    return view('account.kuliner.kunjungankuliner.filterwismanbulan', compact('kunjungan','kuliner', 'wismannegara', 'hash', 'bulan', 'tahun','bulanIndo'));
}




// Menampilkan form input kunjungan
public function createbytanggal($kuliner_id, Request $request)
{
    $hash = new Hashids();
    if (!$kuliner_id) {
        abort(404); // Jika `kuliner_id` tidak valid, return 404
    }

    $company_id = auth()->user()->company->id;
    $kuliner = Kuliner::where('company_id', $company_id)->first();
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();
    $tanggal_kunjungan = Carbon::parse($request->query('tanggal_kunjungan'))->format('Y-m-d');

    // Define the $tanggal variable, you can set it to the current date or any other logic

    return view('account.kuliner.kunjungankuliner.createbytanggal', compact('kuliner', 'kelompok', 'hash','wismannegara','tanggal_kunjungan'));
}

// Menyimpan data kunjungan
public function storewisnuindex(Request $request)
{
    $hash = new Hashids();

    // Decode kuliner_id yang dikirim
    $kuliner_id_decoded = $hash->decode($request->kuliner_id);
    if (empty($kuliner_id_decoded)) {
        return redirect()->back()->with('error', 'ID kuliner tidak valid.')->withInput($request->all());
    }
    $decodedKulinerId = $kuliner_id_decoded[0];

    // Validasi input
    $request->validate([
        'kuliner_id' => 'required',
        'tanggal_kunjungan' => 'required|date',
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'jumlah_laki_laki.*' => 'required|integer|min:0',
        'jumlah_perempuan.*' => 'required|integer|min:0',
        'wismannegara_id' => 'nullable|array',
        'jml_wisman_laki' => 'nullable|array',
        'jml_wisman_perempuan' => 'nullable|array',
        'jml_wisman_laki.*' => 'nullable|integer|min:0',
        'jml_wisman_perempuan.*' => 'nullable|integer|min:0',
    ]);

    // Mulai transaksi
    DB::beginTransaction();
    Log::info('Starting storewisnu method');

    try {
        // Hapus data sebelumnya berdasarkan kuliner_id dan tanggal kunjungan
        $deletedWisnu = WisnuKuliner::where('kuliner_id', $decodedKulinerId)
                                     ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanKuliner::where('kuliner_id', $decodedKulinerId)
                                       ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                       ->delete();

        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

                // Loop untuk data WISNU
            foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
                $jumlah_perempuan = $request->jumlah_perempuan[$kelompok] ?? 0; // Default ke 0 jika tidak ada

                WisnuKuliner::create([
                    'kuliner_id' => $decodedKulinerId,
                    'kelompok_kunjungan_id' => $kelompok,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                    'jumlah_laki_laki' => $jumlah_laki,
                    'jumlah_perempuan' => $jumlah_perempuan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Loop untuk data WISMAN
            foreach ($request->jml_wisman_laki as $negara => $jumlah_wisman_laki) {
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$negara] ?? 0; // Default ke 0 jika tidak ada

                WismanKuliner::create([
                    'kuliner_id' => $decodedKulinerId,
                    'wismannegara_id' => $negara,
                    'jml_wisman_laki' => $jumlah_wisman_laki,
                    'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Commit transaksi
            DB::commit();


        // Kembalikan respons JSON
        return response()->json(['success' => true, 'message' => 'Data kunjungan berhasil disimpan.']);

    } catch (\Exception $e) {
        DB::rollBack();

        // Mencatat detail kesalahan dengan data yang akan disimpan
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([' success' => false, 'message' => 'Gagal menyimpan data kunjungan. Silakan coba lagi. Kesalahan: ' . $e->getMessage()], 500);
    }
}


// Menyimpan data kunjungan
public function storewisnubytanggal(Request $request)
{
    $hash = new Hashids();

    // Decode kuliner_id yang dikirim
    $kuliner_id_decoded = $hash->decode($request->kuliner_id);
    if (empty($kuliner_id_decoded)) {
        return redirect()->back()->with('error', 'ID kuliner tidak valid.')->withInput($request->all());
    }
    $decodedKulinerId = $kuliner_id_decoded[0];
    // Validasi input
    $request->validate([
        'kuliner_id' => 'required',
        'tanggal_kunjungan' => 'required|date',
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'jumlah_laki_laki.*' => 'required|integer|min:0',
        'jumlah_perempuan.*' => 'required|integer|min:0',
        'wismannegara_id' => 'array',
        'jml_wisman_laki' => 'array',
        'jml_wisman_perempuan' => 'array',
        'jml_wisman_laki.*' => 'integer|min:0',
        'jml_wisman_perempuan.*' => 'integer|min:0',
    ]);

    // Cek apakah tanggal sudah ada di database
    $existingWisnu = WisnuKuliner::where('kuliner_id', $decodedKulinerId)
        ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->first();

    if ($existingWisnu) {
        // Jika ada, buat notifikasi untuk mengonfirmasi apakah akan mengubah data
        $formattedDate = Carbon::parse($request->tanggal_kunjungan)->format('d-m-Y');
        return redirect()->back()->with('warning', 'Data Kunjungan dengan Tanggal "' . $formattedDate . '" Sudah Di Input. Pilih Tanggal Lain atau Ubah data di menu')
            ->withInput();
    }

    try {
        // Loop untuk data WISNU (Kulinerwan Nusantara)
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuKuliner::create([
                'kuliner_id' => $decodedKulinerId,
                'kelompok_kunjungan_id' => $kelompok, 
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }

        // Loop untuk data WISMAN (Kulinerwan Mancanegara) hanya jika data tersedia
        if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
            foreach ($request->wismannegara_id as $index => $negara) {
                $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
                WismanKuliner::create([
                    'kuliner_id' => $decodedKulinerId,
                    'wismannegara_id' => $negara,
                    'jml_wisman_laki' => $jumlah_wisman_laki,
                    'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                ]);
            }
        }
        
        return redirect()
        ->route('account.kuliner.kunjungankuliner.indexkunjungankulinerpertahun')->with('success', 'Data kunjungan berhasil disimpan.');
    } catch (\Exception $e) {
        // Log error
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'Gagal menyimpan data kunjungan. Silakan coba lagi.');
    }
}







public function deletewisnutahunan($kuliner_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    
    // Dekripsi `kuliner_id`
    $kuliner_id = $hash->decode($kuliner_id)[0] ?? null;

    if (!$kuliner_id) {
        abort(404); // Jika `kuliner_id` tidak valid, return 404
    }

    try {
        // Mulai transaksi
        DB::beginTransaction();
        
        // Hapus data WISNU berdasarkan kuliner_id dan tanggal_kunjungan
        $deletedWisnu = WisnuKuliner::where('kuliner_id', $kuliner_id)
                                    ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                    ->delete();

        // Hapus data WISMAN berdasarkan kuliner_id dan tanggal_kunjungan
        $deletedWisman = WismanKuliner::where('kuliner_id', $kuliner_id)
                                      ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                      ->delete();

        // Log jumlah data yang dihapus
        Log::info('Deleted WISNU and WISMAN data', [
            'kuliner_id' => $kuliner_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Commit transaksi
        DB::commit();

        return redirect()->route('account.kuliner.kunjungankuliner.indexkunjungankulinerpertahun')
                         ->with('success', 'Data kunjungan berhasil dihapus.');
    } catch (\Exception $e) {
        // Rollback transaksi jika ada kesalahan
        DB::rollBack();

        // Log error
        Log::error('Failed to delete kunjungan data.', [
            'error_message' => $e->getMessage(),
            'kuliner_id' => $kuliner_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->route('account.kuliner.kunjungankuliner.indexkunjungankulinerpertahun')
                         ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
    }
}

    public function deletewisnubulan($kuliner_id, $tanggal_kunjungan)
    {
        $hash = new Hashids();
        
        // Dekripsi `kuliner_id`
        $kuliner_id = $hash->decode($kuliner_id)[0] ?? null;

        if (!$kuliner_id) {
            abort(404); // Jika `kuliner_id` tidak valid, return 404
        }

        try {
            // Mulai transaksi
            DB::beginTransaction();
            
            // Hapus data WISNU berdasarkan kuliner_id dan tanggal_kunjungan
            $deletedWisnu = WisnuKuliner::where('kuliner_id', $kuliner_id)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            // Hapus data WISMAN berdasarkan kuliner_id dan tanggal_kunjungan
            $deletedWisman = WismanKuliner::where('kuliner_id', $kuliner_id)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            // Log jumlah data yang dihapus
            Log::info('Deleted WISNU and WISMAN data', [
                'kuliner_id' => $kuliner_id,
                'tanggal_kunjungan' => $tanggal_kunjungan,
                'deleted_wisnu_count' => $deletedWisnu,
                'deleted_wisman_count' => $deletedWisman,
            ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('account.kuliner.kunjungankuliner.filterwisnubulan')
                            ->with('success', 'Data kunjungan berhasil dihapus.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();

            // Log error
            Log::error('Failed to delete kunjungan data.', [
                'error_message' => $e->getMessage(),
                'kuliner_id' => $kuliner_id,
                'tanggal_kunjungan' => $tanggal_kunjungan,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('account.kuliner.kunjungankuliner.filterwisnubulan')
                            ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
        }
    }

    public function indexkunjunganeventpertahun(Request $request)
{
    $hash = new Hashids();
    $userId = Auth::id();
    $company_id = auth()->user()->company->id;

    // Mengambil semua event berdasarkan created_by_id
    $events = Evencalender::where('created_by_id', $userId)->get();  // Ambil semua event
    
    // Jika tidak ada event, kembalikan dengan pesan error
    if ($events->isEmpty()) {
        return redirect()->back()->withErrors(['error' => 'Anda belum memiliki Event.']);
    }

    $tahun = $request->input('tahun', date('Y')); 

    // Mengambil event_calendar_id dari event yang ditemukan
    $kunjungan = [];
    foreach ($events as $event) {
        $event_calendar_id = $event->id;

        // Ambil data WisnuEvent dan WismanEvent berdasarkan event_calendar_id dan tahun
        $wisnuEvents = WisnuEvent::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->where('event_calendar_id', $event_calendar_id)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->get()
            ->groupBy('tanggal_kunjungan');

        $wismanEvents = WismanEvent::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
            ->where('event_calendar_id', $event_calendar_id)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->get()
            ->groupBy('tanggal_kunjungan');

        // Ambil hanya tanggal yang ada di database
        $tanggalKunjungan = $wisnuEvents->keys()->merge($wismanEvents->keys())->unique()->sortDesc();

        // Olah data kunjungan
        foreach ($tanggalKunjungan as $tanggal) {
            $dataWisnu = $wisnuEvents->get($tanggal, collect());
            $jumlahLakiLaki = $dataWisnu->sum('jumlah_laki_laki');
            $jumlahPerempuan = $dataWisnu->sum('jumlah_perempuan');
            $wisnuByKelompok = $dataWisnu->groupBy('kelompok_kunjungan_id');

            $dataWisman = $wismanEvents->get($tanggal, collect());
            $jmlWismanLaki = $dataWisman->sum('jml_wisman_laki');
            $jmlWismanPerempuan = $dataWisman->sum('jml_wisman_perempuan');
            $wismanByNegara = $dataWisman->groupBy('wismannegara_id');

            $kunjungan[$event->id][$tanggal] = [
                'jumlah_laki_laki' => $jumlahLakiLaki ?: 0,
                'jumlah_perempuan' => $jumlahPerempuan ?: 0,
                'kelompok' => $wisnuByKelompok,
                'jml_wisman_laki' => $jmlWismanLaki ?: 0,
                'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
                'wisman_by_negara' => $wismanByNegara,
            ];
        }
    }

    // Ambil data pendukung
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();

    return view('account.kuliner.kunjunganevent.indexkunjunganeventpertahun', compact(
        'kunjungan', 'events', 'kelompok', 'wismannegara', 'hash', 'tahun'
    ));
}

    
    

    
// Menampilkan form input kunjungan
public function createwisnuevent()
{
    $company_id = auth()->user()->company->id;
    $kelompok = KelompokKunjungan::all();
    $id = Auth::id();

    // Mengambil semua event berdasarkan created_by_id
    $event = Evencalender::where('created_by_id', $id)->get(); // Ambil semua event

    // Pastikan ada event yang ditemukan
    if ($event->isNotEmpty()) {
        // Ambil tanggalmulai dari event pertama
        $tanggal_kunjungan = Carbon::parse($event->first()->tanggalmulai)->format('Y-m-d');
    } else {
        $tanggal_kunjungan = null; // Set null jika tidak ada event
    }

    // Ambil semua data WismanNegara
    $wismannegara = WismanNegara::all();

    // Kirim data ke view
    return view('account.kuliner.kunjunganevent.create', compact('event', 'kelompok', 'wismannegara', 'tanggal_kunjungan'));
}
// Menyimpan data kunjungan
public function storewisnuevent(Request $request)
{
    // Validasi input
    $request->validate([
        'event_calendar_id' => 'required',
        'tanggal_kunjungan' => 'required|date',
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'jumlah_laki_laki.*' => 'required|integer|min:0',
        'jumlah_perempuan.*' => 'required|integer|min:0',
        'wismannegara_id' => 'array',
        'jml_wisman_laki' => 'array',
        'jml_wisman_perempuan' => 'array',
        'jml_wisman_laki.*' => 'integer|min:0',
        'jml_wisman_perempuan.*' => 'integer|min:0',
    ]);

    // Cek apakah tanggal sudah ada di database
    $existingWisnu = WisnuEvent::where('event_calendar_id', $request->event_calendar_id)
        ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->first();

    if ($existingWisnu) {
        // Jika ada, buat notifikasi untuk mengonfirmasi apakah akan mengubah data
        $formattedDate = Carbon::parse($request->tanggal_kunjungan)->format('d-m-Y');
        return redirect()->back()->with('warning', 'Data Kunjungan dengan Tanggal "' . $formattedDate . '" Sudah Di Input. Pilih Tanggal Lain atau Ubah data di menu')
            ->withInput();
    }

    try {
        // Loop untuk data WISNU (Kulinerwan Nusantara)
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuEvent::create([
                'event_calendar_id' => $request->event_calendar_id,
                'kelompok_kunjungan_id' => $kelompok, 
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }

        // Loop untuk data WISMAN (Kulinerwan Mancanegara) hanya jika data tersedia
        if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
            foreach ($request->wismannegara_id as $index => $negara) {
                $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
                WismanEvent::create([
                    'event_calendar_id' => $request->event_calendar_id,
                    'wismannegara_id' => $negara,
                    'jml_wisman_laki' => $jumlah_wisman_laki,
                    'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data kunjungan event berhasil disimpan.');
    } catch (\Exception $e) {
        // Log error
        Log::error('Failed to save kunjungan event to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'Gagal menyimpan data kunjungan event. Silakan coba lagi.');
    }
}

public function storewisnuindexeven(Request $request)
{
    $hash = new Hashids();

    // Decode kuliner_id yang dikirim
    $event_calender_id_decoded = $hash->decode($request->event_calender_id);
    if (empty($event_calender_id_decoded)) {
        Log::error('Failed to decode event_calendar_id.', [
            'event_calender_id' => $request->event_calender_id
        ]);
        return redirect()->back()->with('error', 'ID kuliner tidak valid.')->withInput($request->all());
    }
    $decodedEventId = $event_calender_id_decoded[0];
    
    // Validasi input
    $request->validate([
        'event_calender_id' => 'required',
        'tanggal_kunjungan' => 'required|date',
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'jumlah_laki_laki.*' => 'required|integer|min:0',
        'jumlah_perempuan.*' => 'required|integer|min:0',
        'wismannegara_id' => 'nullable|array',
        'jml_wisman_laki' => 'nullable|array',
        'jml_wisman_perempuan' => 'nullable|array',
        'jml_wisman_laki.*' => 'nullable|integer|min:0',
        'jml_wisman_perempuan.*' => 'nullable|integer|min:0',
    ]);

    // Mulai transaksi
    DB::beginTransaction();
    Log::info('Starting storewisnu method', ['request_data' => $request->all()]);

    try {
        // Hapus data sebelumnya berdasarkan event_calender_id dan tanggal kunjungan
        $deletedWisnu = WisnuEvent::where('event_calender_id', $decodedEventId)
                                     ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanEvent::where('event_calender_id', $decodedEventId)
                                       ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                       ->delete();

        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Loop untuk data WISNU
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok] ?? 0; // Default ke 0 jika tidak ada
            Log::info('Inserting WISNU data', [
                'kelompok' => $kelompok,
                'jumlah_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan
            ]);

            WisnuEvent::create([
                'event_calender_id' => $decodedEventId,
                'kelompok_kunjungan_id' => $kelompok,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Loop untuk data WISMAN
        foreach ($request->jml_wisman_laki as $negara => $jumlah_wisman_laki) {
            $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$negara] ?? 0; // Default ke 0 jika tidak ada
            Log::info('Inserting WISMAN data', [
                'negara' => $negara,
                'jumlah_wisman_laki' => $jumlah_wisman_laki,
                'jumlah_wisman_perempuan' => $jumlah_wisman_perempuan
            ]);

            WismanEvent::create([
                'event_calender_id' => $decodedEventId,
                'wismannegara_id' => $negara,
                'jml_wisman_laki' => $jumlah_wisman_laki,
                'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Commit transaksi
        DB::commit();

        Log::info('Data successfully saved to the database.');
        
        // Kembalikan respons JSON
        return response()->json(['success' => true, 'message' => 'Data kunjungan berhasil disimpan.']);

    } catch (\Exception $e) {
        DB::rollBack();

        // Mencatat detail kesalahan dengan data yang akan disimpan
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json(['success' => false, 'message' => 'Gagal menyimpan data kunjungan. Silakan coba lagi. Kesalahan: ' . $e->getMessage()], 500);
    }
}

// Menampilkan form edit kunjungan
public function editwisnuevent($event_calendar_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    // Dekripsi `event_calendar_id`
    $event_calendar_ids = $hash->decode($event_calendar_id)[0] ?? null;

    if (!$event_calendar_ids) {
        abort(404); // Jika `event_calendar_ids` tidak valid, return 404
    }

    $kelompok = KelompokKunjungan::all();
    $id = Auth::id();

    // Mengambil semua event berdasarkan created_by_id
    $event = Evencalender::where('id', $event_calendar_ids)->first(); // Ambil semua event


    $company_id = auth()->user()->company->id;
    // $kuliner = Kuliner::where('company_id', $company_id)->first();
    $wisnuData = WisnuEvent::where('event_calendar_id', $event_calendar_ids)
    ->where('tanggal_kunjungan', $tanggal_kunjungan)
    ->with('kelompokkunjungan')
    ->get();

    $wismanData = WismanEvent::where('event_calendar_id', $event_calendar_ids)
      ->where('tanggal_kunjungan', $tanggal_kunjungan)
      ->with('wismannegara')
      ->get();
    // Aggregate the data for WISMAN based on wismannegara_id
    $aggregatedWismanData = $wismanData->groupBy('wismannegara_id')->map(function($group) {
        return [
            'wismannegara_id' => $group->first()->wismannegara_id,
            'jml_wisman_laki' => $group->sum('jml_wisman_laki'),
            'jml_wisman_perempuan' => $group->sum('jml_wisman_perempuan'),
        ];
    });

     // Aggregate the data for WISNU based on kelompok_kunjungan_id
     $aggregatedWisnuData = $wisnuData->groupBy('kelompok_kunjungan_id')->map(function($group) {
        return [
            'kelompok_kunjungan_id' => $group->first()->kelompok_kunjungan_id,
            'kelompok_kunjungan_name' => optional($group->first()->kelompokkunjungan)->kelompokkunjungan_name,
            'jumlah_laki_laki' => $group->sum('jumlah_laki_laki'),
            'jumlah_perempuan' => $group->sum('jumlah_perempuan'),
        ];
    }); 

    // Get other data
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();

    // Pass data to the view
    return view('account.kuliner.kunjunganevent.edit', compact('wisnuData', 'hash','aggregatedWismanData','aggregatedWisnuData','tanggal_kunjungan','wismanData', 'event', 'kelompok', 'wismannegara', 'hash'));
}

public function updatewisnuevent(Request $request, $tanggal_kunjungan)
{
    $hash = new Hashids();

    // Decode event_calendar_id yang dikirim
    $event_calendar_id_decoded = $hash->decode($request->event_calendar_id);
    if (empty($event_calendar_id_decoded)) {
        return redirect()->back()->with('error', 'ID kuliner tidak valid.')->withInput($request->all());
    }
    $decodedEventId = $event_calendar_id_decoded[0];

    // Validasi input
    $request->validate([
        'event_calendar_id' => 'required', // Validasi event_calendar_id sebagai parameter
        'tanggal_kunjungan' => 'required|date', 
        'jumlah_laki_laki' => 'required|array',
        'jumlah_perempuan' => 'required|array',
        'jumlah_laki_laki.*' => 'required|integer|min:0',
        'jumlah_perempuan.*' => 'required|integer|min:0',
        'wismannegara_id' => 'array',
        'jml_wisman_laki' => 'array',
        'jml_wisman_perempuan' => 'array',
        'jml_wisman_laki.*' => 'integer|min:0',
        'jml_wisman_perempuan.*' => 'integer|min:0',
    ]);

    // Mulai transaksi
    DB::beginTransaction();
    Log::info('Starting updatewisnu method', ['tanggal_kunjungan' => $tanggal_kunjungan]);

    try {
        // Hapus data sebelumnya berdasarkan decoded event_calendar_id dan tanggal kunjungan
        $deletedWisnu = WisnuEvent::where('event_calendar_id', $decodedEventId)
                                     ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanEvent::where('event_calendar_id', $decodedEventId)
                                       ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                       ->delete();

        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Loop untuk data WISNU
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuEvent::create([
                'event_calendar_id' => $decodedEventId,
                'kelompok_kunjungan_id' => $kelompok,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'updated_at' => now(),
            ]);
        }

       // Loop untuk data WISMAN (Eventwan Mancanegara) hanya jika data tersedia
       if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
        foreach ($request->wismannegara_id as $index => $negara) {
            $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
            $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
            WismanEvent::create([
                'event_calendar_id' => $decodedEventId,
                'wismannegara_id' => $negara,
                'jml_wisman_laki' => $jumlah_wisman_laki,
                'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }
    }

        // Commit transaksi
        DB::commit();
        
        // Alihkan ke halaman index dengan pesan sukses
        return redirect()->route('account.kuliner.kunjunganevent.indexkunjunganeventpertahun')->with('success', 'Data kunjungan berhasil diperbarui.');

    } catch (\Exception $e) {
        DB::rollBack();

        // Mencatat detail kesalahan dengan data yang akan disimpan
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString(),
            'decoded_event_calendar_id' => $decodedEventId,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jumlah_laki_laki' => $request->jumlah_laki_laki,
            'jumlah_perempuan' => $request->jumlah_perempuan,
            'wismannegara_id' => $request->wismannegara_id,
            'jml_wisman_laki' => $request->jml_wisman_laki,
            'jml_wisman_perempuan' => $request->jml_wisman_perempuan,
        ]);

        return redirect()->back()->with('error', 'Gagal menyimpan data kunjungan. Silakan coba lagi. Kesalahan: ' . $e->getMessage())
                                 ->withInput($request->all());
    }
}


// Fungsi untuk menghapus data kunjungan
public function deletewisnuevent($event_calendar_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    
    // Dekripsi `event_calendar_id`
    $event_calendar_id = $hash->decode($event_calendar_id)[0] ?? null;

    if (!$event_calendar_id) {
        abort(404); // Jika `event_calendar_id` tidak valid, return 404
    }

    try {
        // Mulai transaksi
        DB::beginTransaction();
        
        // Hapus data WISNU berdasarkan event_calendar_id dan tanggal_kunjungan
        $deletedWisnu = WisnuEvent::where('event_calendar_id', $event_calendar_id)
                                    ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                    ->delete();

        // Hapus data WISMAN berdasarkan event_calendar_id dan tanggal_kunjungan
        $deletedWisman = WismanEvent::where('event_calendar_id', $event_calendar_id)
                                      ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                      ->delete();

        // Log jumlah data yang dihapus
        Log::info('Deleted WISNU and WISMAN data', [
            'event_calendar_id' => $event_calendar_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Commit transaksi
        DB::commit();

        return redirect()->route('account.kuliner.kunjunganevent.indexkunjunganeventpertahun')
                         ->with('success', 'Data kunjungan berhasil dihapus.');
    } catch (\Exception $e) {
        // Rollback transaksi jika ada kesalahan
        DB::rollBack();

        // Log error
        Log::error('Failed to delete kunjungan data.', [
            'error_message' => $e->getMessage(),
            'event_calendar_id' => $event_calendar_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->route('account.kuliner.kunjunganevent.indexkunjunganeventpertahun')
                         ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
    }
}



public function realtime(Request $request)
{
    $hash = new Hashids();
    $company_id = auth()->user()->company->id;

    // Ambil data Kuliner berdasarkan company_id
    $kuliner = Kuliner::where('company_id', $company_id)->first();

    if (!$kuliner) {
        return redirect()->back()->withErrors(['error' => 'Kuliner tidak ditemukan untuk pengguna ini.']);
    }

    $kuliner_id = $kuliner->id;

    // Menentukan periode berdasarkan filter yang dipilih
    $filter = $request->input('filter', 'hari_ini'); // Default filter adalah 'hari_ini'

    if ($filter == 'hari_ini') {
        $startDate = Carbon::today()->startOfDay();
        $endDate = Carbon::today()->endOfDay();
    } elseif ($filter == 'minggu_ini') {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
    } elseif ($filter == 'bulan_ini') {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    } else {
        // Default ke bulan ini jika tidak ada filter yang cocok
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    }

    // Rentang tanggal untuk periode yang dipilih
    $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);

    // Ambil data WisnuKuliner berdasarkan kuliner_id
    $wisnuKunjungan = WisnuKuliner::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
        ->where('kuliner_id', $kuliner_id)
        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
        ->get()
        ->groupBy('tanggal_kunjungan');

    // Ambil data WismanKuliner berdasarkan kuliner_id
    $wismanKunjungan = WismanKuliner::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
        ->where('kuliner_id', $kuliner_id)
        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
        ->get()
        ->groupBy('tanggal_kunjungan');

    // Olah data kunjungan
    $kunjungan = [];
    foreach ($tanggalRentang as $tanggal) {
        $tanggalFormat = $tanggal->format('Y-m-d');

        // Ambil data kunjungan dari WisnuKuliner
        $dataWisnu = $wisnuKunjungan->get($tanggalFormat, collect());
        $jumlahLakiLaki = $dataWisnu->sum('jumlah_laki_laki');
        $jumlahPerempuan = $dataWisnu->sum('jumlah_perempuan');
        $wisnuByKelompok = $dataWisnu->groupBy('kelompok_kunjungan_id');

        // Ambil data kunjungan dari WismanKuliner
        $dataWisman = $wismanKunjungan->get($tanggalFormat, collect());
        $jmlWismanLaki = $dataWisman->sum('jml_wisman_laki');
        $jmlWismanPerempuan = $dataWisman->sum('jml_wisman_perempuan');
        $wismanByNegara = $dataWisman->groupBy('wismannegara_id');

        $kunjungan[$tanggalFormat] = [
            'jumlah_laki_laki' => $jumlahLakiLaki ?: 0,
            'jumlah_perempuan' => $jumlahPerempuan ?: 0,
            'kelompok' => $wisnuByKelompok,
            'jml_wisman_laki' => $jmlWismanLaki ?: 0,
            'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
            'wisman_by_negara' => $wismanByNegara,
        ];
    }

    // Sort data berdasarkan tanggal
    $kunjungan = collect($kunjungan)->sortBy(function ($item, $key) {
        return $key;
    });

    // Persiapkan data untuk grafik
    $dates = $kunjungan->keys()->toArray();
    $jumlahLakiLaki = $kunjungan->pluck('jumlah_laki_laki')->toArray();
    $jumlahPerempuan = $kunjungan->pluck('jumlah_perempuan')->toArray();
    $jmlWismanLaki = $kunjungan->pluck('jml_wisman_laki')->toArray();
    $jmlWismanPerempuan = $kunjungan->pluck('jml_wisman_perempuan')->toArray();

    // Ambil data pendukung
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();

    return view('account.kuliner.kunjungankuliner.realtime', compact(
        'kunjungan', 'kuliner', 'kelompok', 'wismannegara', 'hash', 'filter', 'startDate', 'endDate',
        'dates', 'jumlahLakiLaki', 'jumlahPerempuan', 'jmlWismanLaki', 'jmlWismanPerempuan'
    ));
}



}

