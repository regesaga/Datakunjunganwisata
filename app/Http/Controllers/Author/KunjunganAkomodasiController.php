<?php

namespace App\Http\Controllers\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\WisnuAkomodasi;
use App\Models\KelompokKunjungan;
use App\Models\WismanAkomodasi;
use App\Models\WismanNegara;
use App\Models\Akomodasi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Carbon\Carbon; 


class KunjunganAkomodasiController extends Controller
{
    public function indexkunjunganakomodasi(Request $request)
    {
        $hash = new Hashids();
        $company_id = auth()->user()->company->id;
    
        // Ambil data Akomodasi berdasarkan company_id
        $akomodasi = Akomodasi::where('company_id', $company_id)->first();
        
        if (!$akomodasi) {
            return redirect()->back()->withErrors(['error' => 'Akomodasi tidak ditemukan untuk pengguna ini.']);
        }
    
        $akomodasi_id = $akomodasi->id; // Mendapatkan akomodasi_id dari data Akomodasi
    
        // Filter bulan dan tahun dari request atau default saat ini
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
    
        // Periode waktu untuk bulan yang dipilih
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
    
        // Buat rentang tanggal dari startDate hingga endDate
        $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);
    
        // Ambil data WisnuAkomodasi berdasarkan akomodasi_id
        $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->where('akomodasi_id', $akomodasi_id) // Filter berdasarkan akomodasi_id
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->get()
            ->groupBy('tanggal_kunjungan');
    
        // Ambil data WismanAkomodasi berdasarkan akomodasi_id
        $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
            ->where('akomodasi_id', $akomodasi_id) // Filter berdasarkan akomodasi_id
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->get()
            ->groupBy('tanggal_kunjungan');
    
        // Olah data kunjungan
        $kunjungan = [];
        foreach ($tanggalRentang as $tanggal) {
            $tanggalFormat = $tanggal->format('Y-m-d');
    
            // Ambil data kunjungan dari WisnuAkomodasi
            $dataWisnu = $wisnuKunjungan->get($tanggalFormat, collect());
            $jumlahLakiLaki = $dataWisnu->sum('jumlah_laki_laki');
            $jumlahPerempuan = $dataWisnu->sum('jumlah_perempuan');
    
            // Ambil data kunjungan dari WismanAkomodasi
            $dataWisman = $wismanKunjungan->get($tanggalFormat, collect());
            $jmlWismanLaki = $dataWisman->sum('jml_wisman_laki');
            $jmlWismanPerempuan = $dataWisman->sum('jml_wisman_perempuan');
            $wismanByNegara = $dataWisman->groupBy('wismannegara_id');
    
            $kunjungan[$tanggalFormat] = [
                'jumlah_laki_laki' => $jumlahLakiLaki ?: 0,
                'jumlah_perempuan' => $jumlahPerempuan ?: 0,
                'kelompok' => $dataWisnu,
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
    
        return view('account.akomodasi.kunjunganakomodasi.index', compact(
            'kunjungan', 'akomodasi', 'kelompok', 'wismannegara', 'hash', 'bulan', 'tahun'
        ));
    }
    
        
    public function indexkunjunganakomodasipertahun(Request $request)
    {
        $hash = new Hashids();
        $company_id = auth()->user()->company->id;
        $akomodasi = Akomodasi::where('company_id', $company_id)->first();
    
        if (!$akomodasi) {
            return redirect()->back()->with('error', 'Akomodasi tidak ditemukan.');
        }
        $akomodasi_id = $akomodasi->id; // Dapatkan akomodasi_id untuk filtering data
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
             $wisnuKunjungan = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                 ->whereDate('tanggal_kunjungan', $tanggal)
                 ->get()
                 ->groupBy('kelompok_kunjungan_id');
         
             // Ambil data Wisman
             $wismanKunjungan = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
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
    
            // Ambil data Wisnu hanya untuk akomodasi terkait
            $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                ->where('akomodasi_id', $akomodasi->id)
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get()
                ->groupBy('kelompok_kunjungan_id');
    
            // Ambil data Wisman hanya untuk akomodasi terkait
            $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                ->where('akomodasi_id', $akomodasi->id)
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
    
        return view('account.akomodasi.kunjunganakomodasi.indexkunjunganakomodasipertahun', compact('kunjungan','akomodasi_id', 'akomodasi', 'kelompok', 'wismannegara', 'hash', 'tahun','bytgl','totalKeseluruhan', 'totalKunjungan'));
    }
    
            public function dashboard(Request $request)
            {
                $company_id = auth()->user()->company->id;
                $akomodasi = Akomodasi::where('company_id', $company_id)->first(); // Mendapatkan akomodasi terkait
                $hash = new Hashids();
            
                if (!$akomodasi) {
                    return redirect()->back()->with('error', 'Akomodasi tidak ditemukan untuk perusahaan Anda.');
                }
            
                $akomodasi_id = $akomodasi->id; // Dapatkan akomodasi_id untuk filtering data
            
                // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
                $year = $request->input('year', date('Y'));
            
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
                
                    // Ambil data Wisnu
                    $wisnuKunjungan = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                        ->whereDate('tanggal_kunjungan', $tanggal)
                        ->get()
                        ->groupBy('kelompok_kunjungan_id');
                
                    // Ambil data Wisman
                    $wismanKunjungan = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
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
                    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
                    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();
            
                    // Hitung total kunjungan untuk setiap kategori, filter berdasarkan akomodasi_id
                    $totalLakiLaki = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_laki_laki');
            
                    $totalPerempuan = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_perempuan');
            
                    $totalWismanLaki = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_laki');
            
                    $totalWismanPerempuan = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
                        ->whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_perempuan');
            
                    // Ambil data kunjungan
                    $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                        ->where('akomodasi_id', $akomodasi_id)
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->get()
                        ->groupBy('kelompok_kunjungan_id');
            
                    $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                        ->where('akomodasi_id', $akomodasi_id)
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->get()
                        ->groupBy('wismannegara_id');
            
                    // Simpan data kunjungan per bulan ke dalam array
                    $kunjungan[$month] = [
                        'total_laki_laki' => $totalLakiLaki,
                        'total_perempuan' => $totalPerempuan,
                        'total_wisman_laki' => $totalWismanLaki,
                        'total_wisman_perempuan' => $totalWismanPerempuan,
                        'jumlah_laki_laki' => $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki')),
                        'jumlah_perempuan' => $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan')),
                        'kelompok' => $wisnuKunjungan,
                        'jml_wisman_laki' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_laki')),
                        'jml_wisman_perempuan' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_perempuan')),
                        'wisman_by_negara' => $wismanKunjungan,
                    ];
                }
            
                // Ambil data kelompok kunjungan dan negara akomodasiwan
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
                            'value' => collect($kunjungan)->sum(function($dataBulan) use ($kelompokItem) {
                                return $dataBulan['kelompok']->get($kelompokItem->id, collect())->sum(function($item) {
                                    return $item['jumlah_laki_laki'] + $item['jumlah_perempuan'];
                                });
                            })
                        ];
                    }

                    // Persiapkan data untuk grafik bar
                    $negaraData = [];
                    foreach ($wismannegara as $negara) {
                        $negaraData[] = [
                            'name' => $negara->wismannegara_name,
                            'value' => collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                                return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum(function($item) {
                                    return $item['jml_wisman_laki'] + $item['jml_wisman_perempuan'];
                                });
                            })
                        ];
                    }
            
            
                    return view('account.akomodasi.kunjunganakomodasi.dashboard', compact(
                        'kunjungan', 'kelompok','kelompokData','wismannegara', 'akomodasi','bytgl', 'hash', 'year', 'totalKeseluruhan','bulan', 'totalKunjungan','totalKunjunganLaki','totalKunjunganPerempuan', 'negaraData'
                    ));
            }


        public function filterbyinput(Request $request)
    {
        $company_id = auth()->user()->company->id;
        $kelompok = KelompokKunjungan::all();
        $akomodasi = Akomodasi::where('company_id', $company_id)->first();
        $wismannegara = WismanNegara::all();

        // Define the $tanggal variable, you can set it to the current date or any other logic
        $tanggal = now()->format('d-m-Y'); // This sets $tanggal to today's date in Y-m-d format

        return view('account.akomodasi.kunjunganakomodasi.filterbyinput', compact('akomodasi', 'kelompok', 'wismannegara', 'tanggal'));
    }

    public function filterbulan(Request $request)
    {
        $company_id = auth()->user()->company->id;
        $akomodasi = Akomodasi::where('company_id', $company_id)->first();
        $hash = new Hashids();
    
        // Jika akomodasi tidak ditemukan, kembalikan error
        if (!$akomodasi) {
            return redirect()->back()->with('error', 'Akomodasi tidak ditemukan.');
        }
    
        // Ambil tahun dan bulan dari request, default ke tahun dan bulan saat ini jika tidak ada input
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
    
        // Fetch data dari database dengan filter tahun, bulan, dan akomodasi_id
        $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->where('akomodasi_id', $akomodasi->id) // Filter berdasarkan akomodasi_id
            ->whereYear('tanggal_kunjungan', $year)
            ->whereMonth('tanggal_kunjungan', $month)
            ->get()
            ->groupBy('tanggal_kunjungan');
    
        $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
            ->where('akomodasi_id', $akomodasi->id) // Filter berdasarkan akomodasi_id
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
        return view('account.akomodasi.kunjunganakomodasi.filterbulan', compact('kunjungan', 'akomodasi', 'kelompok', 'wismannegara', 'hash', 'year', 'month'));
    }
    
    
    public function filtertahun(Request $request)
    {
        $company_id = auth()->user()->company->id;
        $akomodasi = Akomodasi::where('company_id', $company_id)->first();
        $hash = new Hashids();
    
        // Pastikan ada data akomodasi terkait
        if (!$akomodasi) {
            return redirect()->back()->with('error', 'Akomodasi tidak ditemukan untuk perusahaan Anda.');
        }
    
        $akomodasi_id = $akomodasi->id;
    
        // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
        $year = $request->input('year', date('Y'));
    
        // Buat array untuk menyimpan data kunjungan per bulan
        $kunjungan = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalLakiLaki = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jumlah_laki_laki');
    
            $totalPerempuan = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jumlah_perempuan');
    
            $totalWismanLaki = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->sum('jml_wisman_laki');
    
            $totalWismanPerempuan = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
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
        return view('account.akomodasi.kunjunganakomodasi.filtertahun', compact('kunjungan', 'akomodasi', 'hash', 'year', 'totalKeseluruhan'));
    }
    
    

    public function filterwisnubulan(Request $request)
{
    $hash = new Hashids();
    $company_id = auth()->user()->company->id;
    
    // Fetch akomodasi based on company_id and ensure we get the akomodasi_id
    $akomodasi = Akomodasi::where('company_id', $company_id)->first(); 
    
    // Check if akomodasi is found
    if (!$akomodasi) {
        return response()->json(['error' => 'Akomodasi not found for this company'], 404);
    }
    
    $akomodasi_id = $akomodasi->id; // Get the akomodasi_id
    
    // Ambil bulan dan tahun dari request (default ke bulan dan tahun saat ini)
    $bulan = $request->input('bulan', date('m')); // Default bulan saat ini
    $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini
    
    // Buat rentang tanggal untuk bulan yang dipilih
    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
    
    // Buat rentang tanggal dari startDate hingga endDate
    $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);
   
    // Ambil data WisnuAkomodasi berdasarkan akomodasi_id
    $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
    ->where('akomodasi_id', $akomodasi_id) // Filter berdasarkan akomodasi_id
    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
    ->get()
    ->groupBy('tanggal_kunjungan');


    $kunjungan = [];
    foreach ($tanggalRentang as $tanggal ) {
        $tanggalFormat = $tanggal->format('Y-m-d');

         // Ambil data kunjungan dari WisnuAkomodasi
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
    
    return view('account.akomodasi.kunjunganakomodasi.filterwisnubulan', compact('kunjungan','akomodasi','kelompok', 'hash', 'bulan', 'tahun'));
}

public function filterwismanbulan(Request $request)
{
    $hash = new Hashids();
    $company_id = auth()->user()->company->id;
    
    // Fetch akomodasi based on company_id and ensure we get the akomodasi_id
    $akomodasi = Akomodasi::where('company_id', $company_id)->first(); 
    
    // Check if akomodasi is found
    if (!$akomodasi) {
        return response()->json(['error' => 'Akomodasi not found for this company'], 404);
    }
    
    $akomodasi_id = $akomodasi->id; // Get the akomodasi_id
    
    // Ambil bulan dan tahun dari request (default ke bulan dan tahun saat ini)
    $bulan = $request->input('bulan', date('m')); // Default bulan saat ini
    $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini
    
    // Buat rentang tanggal untuk bulan yang dipilih
    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();

     // Buat rentang tanggal dari startDate hingga endDate
     $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);
    
    // Ambil data WismanAkomodasi berdasarkan akomodasi_id
    $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
    ->where('akomodasi_id', $akomodasi_id) // Filter berdasarkan akomodasi_id
    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
    ->get()
    ->groupBy('tanggal_kunjungan');


    $kunjungan = [];
    foreach ($tanggalRentang as $tanggal) {
        $tanggalFormat = $tanggal->format('Y-m-d');
        // Ambil data kunjungan dari WisnuAkomodasi

        // Ambil data kunjungan dari WismanAkomodasi
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
    
    return view('account.akomodasi.kunjunganakomodasi.filterwismanbulan', compact('kunjungan','akomodasi', 'wismannegara', 'hash', 'bulan', 'tahun'));
}


// Menampilkan form input kunjungan
public function createwisnu()
{
    $company_id = auth()->user()->company->id;
    $kelompok = KelompokKunjungan::all();
    $akomodasi = Akomodasi::where('company_id', $company_id)->first();
    $wismannegara = WismanNegara::all();

    // Define the $tanggal variable, you can set it to the current date or any other logic
    $tanggal = now()->format('d-m-Y'); // This sets $tanggal to today's date in Y-m-d format

    return view('account.akomodasi.kunjunganakomodasi.create', compact('akomodasi', 'kelompok', 'wismannegara', 'tanggal'));
}

// Menampilkan form input kunjungan
public function createbytanggal($akomodasi_id, Request $request)
{
    $hash = new Hashids();
    if (!$akomodasi_id) {
        abort(404); // Jika `akomodasi_id` tidak valid, return 404
    }

    $company_id = auth()->user()->company->id;
    $akomodasi = Akomodasi::where('company_id', $company_id)->first();
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();
    $tanggal_kunjungan = Carbon::parse($request->query('tanggal_kunjungan'))->format('Y-m-d');

    // Define the $tanggal variable, you can set it to the current date or any other logic

    return view('account.akomodasi.kunjunganakomodasi.createbytanggal', compact('akomodasi', 'kelompok', 'hash','wismannegara','tanggal_kunjungan'));
}

// Menyimpan data kunjungan
public function storewisnuindex(Request $request)
{
    $hash = new Hashids();

    // Decode akomodasi_id yang dikirim
    $akomodasi_id_decoded = $hash->decode($request->akomodasi_id);
    if (empty($akomodasi_id_decoded)) {
        return redirect()->back()->with('error', 'ID akomodasi tidak valid.')->withInput($request->all());
    }
    $decodedAkomodasiId = $akomodasi_id_decoded[0];

    // Validasi input
    $request->validate([
        'akomodasi_id' => 'required',
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
        // Hapus data sebelumnya berdasarkan akomodasi_id dan tanggal kunjungan
        $deletedWisnu = WisnuAkomodasi::where('akomodasi_id', $decodedAkomodasiId)
                                     ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanAkomodasi::where('akomodasi_id', $decodedAkomodasiId)
                                       ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                       ->delete();

        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

                // Loop untuk data WISNU
            foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
                $jumlah_perempuan = $request->jumlah_perempuan[$kelompok] ?? 0; // Default ke 0 jika tidak ada

                WisnuAkomodasi::create([
                    'akomodasi_id' => $decodedAkomodasiId,
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

                WismanAkomodasi::create([
                    'akomodasi_id' => $decodedAkomodasiId,
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

    // Decode akomodasi_id yang dikirim
    $akomodasi_id_decoded = $hash->decode($request->akomodasi_id);
    if (empty($akomodasi_id_decoded)) {
        return redirect()->back()->with('error', 'ID akomodasi tidak valid.')->withInput($request->all());
    }
    $decodedAkomodasiId = $akomodasi_id_decoded[0];
    // Validasi input
    $request->validate([
        'akomodasi_id' => 'required',
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
    $existingWisnu = WisnuAkomodasi::where('akomodasi_id', $decodedAkomodasiId)
        ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->first();

    if ($existingWisnu) {
        // Jika ada, buat notifikasi untuk mengonfirmasi apakah akan mengubah data
        $formattedDate = Carbon::parse($request->tanggal_kunjungan)->format('d-m-Y');
        return redirect()->back()->with('warning', 'Data Kunjungan dengan Tanggal "' . $formattedDate . '" Sudah Di Input. Pilih Tanggal Lain atau Ubah data di menu')
            ->withInput();
    }

    try {
        // Loop untuk data WISNU (Akomodasiwan Nusantara)
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuAkomodasi::create([
                'akomodasi_id' => $decodedAkomodasiId,
                'kelompok_kunjungan_id' => $kelompok, 
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }

        // Loop untuk data WISMAN (Akomodasiwan Mancanegara) hanya jika data tersedia
        if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
            foreach ($request->wismannegara_id as $index => $negara) {
                $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
                WismanAkomodasi::create([
                    'akomodasi_id' => $decodedAkomodasiId,
                    'wismannegara_id' => $negara,
                    'jml_wisman_laki' => $jumlah_wisman_laki,
                    'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                ]);
            }
        }
        
        return redirect()
        ->route('account.akomodasi.kunjunganakomodasi.indexkunjunganakomodasipertahun')->with('success', 'Data kunjungan berhasil disimpan.');
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

// Menyimpan data kunjungan
public function storewisnu(Request $request)
{
    // Validasi input
    $request->validate([
        'akomodasi_id' => 'required',
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
    $existingWisnu = WisnuAkomodasi::where('akomodasi_id', $request->akomodasi_id)
        ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->first();

    if ($existingWisnu) {
        // Jika ada, buat notifikasi untuk mengonfirmasi apakah akan mengubah data
        $formattedDate = Carbon::parse($request->tanggal_kunjungan)->format('d-m-Y');
        return redirect()->back()->with('warning', 'Data Kunjungan dengan Tanggal "' . $formattedDate . '" Sudah Di Input. Pilih Tanggal Lain atau Ubah data di menu')
            ->withInput();
    }

    try {
        // Loop untuk data WISNU (Akomodasiwan Nusantara)
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuAkomodasi::create([
                'akomodasi_id' => $request->akomodasi_id,
                'kelompok_kunjungan_id' => $kelompok, 
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }

        // Loop untuk data WISMAN (Akomodasiwan Mancanegara) hanya jika data tersedia
        if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
            foreach ($request->wismannegara_id as $index => $negara) {
                $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
                WismanAkomodasi::create([
                    'akomodasi_id' => $request->akomodasi_id,
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
public function editwisnu($akomodasi_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    // Dekripsi `akomodasi_id`
    $akomodasi_id = $hash->decode($akomodasi_id)[0] ?? null;

    if (!$akomodasi_id) {
        abort(404); // Jika `akomodasi_id` tidak valid, return 404
    }

    $company_id = auth()->user()->company->id;
    $akomodasi = Akomodasi::where('company_id', $company_id)->first();
    $wisnuData = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
    ->where('tanggal_kunjungan', $tanggal_kunjungan)
    ->with('kelompokkunjungan')
    ->get();

    $wismanData = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
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
    return view('account.akomodasi.kunjunganakomodasi.edit', compact('wisnuData', 'hash','aggregatedWismanData','aggregatedWisnuData','tanggal_kunjungan','wismanData', 'akomodasi', 'kelompok', 'wismannegara', 'hash'));
}

public function updatewisnu(Request $request, $tanggal_kunjungan)
{
    $hash = new Hashids();

    // Decode akomodasi_id yang dikirim
    $akomodasi_id_decoded = $hash->decode($request->akomodasi_id);
    if (empty($akomodasi_id_decoded)) {
        return redirect()->back()->with('error', 'ID akomodasi tidak valid.')->withInput($request->all());
    }
    $decodedAkomodasiId = $akomodasi_id_decoded[0];

    // Validasi input
    $request->validate([
        'akomodasi_id' => 'required', // Validasi akomodasi_id sebagai parameter
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
        // Hapus data sebelumnya berdasarkan decoded akomodasi_id dan tanggal kunjungan
        $deletedWisnu = WisnuAkomodasi::where('akomodasi_id', $decodedAkomodasiId)
                                     ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanAkomodasi::where('akomodasi_id', $decodedAkomodasiId)
                                       ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                       ->delete();

        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Loop untuk data WISNU
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuAkomodasi::create([
                'akomodasi_id' => $decodedAkomodasiId,
                'kelompok_kunjungan_id' => $kelompok,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'updated_at' => now(),
            ]);
        }

       // Loop untuk data WISMAN (Akomodasiwan Mancanegara) hanya jika data tersedia
       if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
        foreach ($request->wismannegara_id as $index => $negara) {
            $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
            $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
            WismanAkomodasi::create([
                'akomodasi_id' => $decodedAkomodasiId,
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
        return redirect()->route('account.akomodasi.kunjunganakomodasi.indexkunjunganakomodasipertahun')->with('success', 'Data kunjungan berhasil diperbarui.');

    } catch (\Exception $e) {
        DB::rollBack();

        // Mencatat detail kesalahan dengan data yang akan disimpan
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString(),
            'decoded_akomodasi_id' => $decodedAkomodasiId,
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
public function deletewisnu($akomodasi_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    
    // Dekripsi `akomodasi_id`
    $akomodasi_id = $hash->decode($akomodasi_id)[0] ?? null;

    if (!$akomodasi_id) {
        abort(404); // Jika `akomodasi_id` tidak valid, return 404
    }

    try {
        // Mulai transaksi
        DB::beginTransaction();
        
        // Hapus data WISNU berdasarkan akomodasi_id dan tanggal_kunjungan
        $deletedWisnu = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                                    ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                    ->delete();

        // Hapus data WISMAN berdasarkan akomodasi_id dan tanggal_kunjungan
        $deletedWisman = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
                                      ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                      ->delete();

        // Log jumlah data yang dihapus
        Log::info('Deleted WISNU and WISMAN data', [
            'akomodasi_id' => $akomodasi_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Commit transaksi
        DB::commit();

        return redirect()->route('account.akomodasi.kunjunganakomodasi.index')
                         ->with('success', 'Data kunjungan berhasil dihapus.');
    } catch (\Exception $e) {
        // Rollback transaksi jika ada kesalahan
        DB::rollBack();

        // Log error
        Log::error('Failed to delete kunjungan data.', [
            'error_message' => $e->getMessage(),
            'akomodasi_id' => $akomodasi_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->route('account.akomodasi.kunjunganakomodasi.index')
                         ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
    }
}

public function deletewisnutahunan($akomodasi_id, $tanggal_kunjungan)
{
    $hash = new Hashids();
    
    // Dekripsi `akomodasi_id`
    $akomodasi_id = $hash->decode($akomodasi_id)[0] ?? null;

    if (!$akomodasi_id) {
        abort(404); // Jika `akomodasi_id` tidak valid, return 404
    }

    try {
        // Mulai transaksi
        DB::beginTransaction();
        
        // Hapus data WISNU berdasarkan akomodasi_id dan tanggal_kunjungan
        $deletedWisnu = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                                    ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                    ->delete();

        // Hapus data WISMAN berdasarkan akomodasi_id dan tanggal_kunjungan
        $deletedWisman = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
                                      ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                      ->delete();

        // Log jumlah data yang dihapus
        Log::info('Deleted WISNU and WISMAN data', [
            'akomodasi_id' => $akomodasi_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Commit transaksi
        DB::commit();

        return redirect()->route('account.akomodasi.kunjunganakomodasi.indexkunjunganakomodasipertahun')
                         ->with('success', 'Data kunjungan berhasil dihapus.');
    } catch (\Exception $e) {
        // Rollback transaksi jika ada kesalahan
        DB::rollBack();

        // Log error
        Log::error('Failed to delete kunjungan data.', [
            'error_message' => $e->getMessage(),
            'akomodasi_id' => $akomodasi_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->route('account.akomodasi.kunjunganakomodasi.indexkunjunganakomodasipertahun')
                         ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
    }
}

    public function deletewisnubulan($akomodasi_id, $tanggal_kunjungan)
    {
        $hash = new Hashids();
        
        // Dekripsi `akomodasi_id`
        $akomodasi_id = $hash->decode($akomodasi_id)[0] ?? null;

        if (!$akomodasi_id) {
            abort(404); // Jika `akomodasi_id` tidak valid, return 404
        }

        try {
            // Mulai transaksi
            DB::beginTransaction();
            
            // Hapus data WISNU berdasarkan akomodasi_id dan tanggal_kunjungan
            $deletedWisnu = WisnuAkomodasi::where('akomodasi_id', $akomodasi_id)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            // Hapus data WISMAN berdasarkan akomodasi_id dan tanggal_kunjungan
            $deletedWisman = WismanAkomodasi::where('akomodasi_id', $akomodasi_id)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            // Log jumlah data yang dihapus
            Log::info('Deleted WISNU and WISMAN data', [
                'akomodasi_id' => $akomodasi_id,
                'tanggal_kunjungan' => $tanggal_kunjungan,
                'deleted_wisnu_count' => $deletedWisnu,
                'deleted_wisman_count' => $deletedWisman,
            ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('account.akomodasi.kunjunganakomodasi.filterwisnubulan')
                            ->with('success', 'Data kunjungan berhasil dihapus.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();

            // Log error
            Log::error('Failed to delete kunjungan data.', [
                'error_message' => $e->getMessage(),
                'akomodasi_id' => $akomodasi_id,
                'tanggal_kunjungan' => $tanggal_kunjungan,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('account.akomodasi.kunjunganakomodasi.filterwisnubulan')
                            ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
        }
    }





}

