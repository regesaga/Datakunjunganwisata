<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\WisnuAkomodasi;
use App\Models\CategoryAkomodasi;
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


class AdminKunjunganAkomodasiController extends Controller
{
    public function indexkunjunganakomodasi(Request $request)
        {
            $hash = new Hashids();
            $company_id = auth()->user()->company->id;

            // Ambil kategori akomodasi untuk dropdown
            $kategoriAkomodasi = CategoryAkomodasi::all();

            $categoryakomodasi_id = $request->input('categoryakomodasi_id', null);
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

            // Filter akomodasi berdasarkan kategori (tampilkan semua jika tidak ada kategori yang dipilih)
            $akomodasi = Akomodasi::when($categoryakomodasi_id, function($query) use ($categoryakomodasi_id) {
                return $query->where('categoryakomodasi_id', $categoryakomodasi_id);
            })->get();

            // Tentukan start dan end date sesuai bulan dan tahun
            $startDate = Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();

            // Ambil data kunjungan Wisnu untuk bulan yang dipilih
            $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id', 'akomodasi_id')
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get();

            // Ambil data kunjungan Wisman untuk bulan yang dipilih
            $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id', 'akomodasi_id')
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get();

            // Proses data kunjungan dan akomodasi
            $kunjungan = [];
            $totalWismanLaki = 0;
            $totalWismanPerempuan = 0;

            foreach ($akomodasi as $akomodasiItem) {
                // Ambil data kunjungan untuk ID akomodasi tertentu
                $wisnuData = $wisnuKunjungan->where('akomodasi_id', $akomodasiItem->id);
                $wismanData = $wismanKunjungan->where('akomodasi_id', $akomodasiItem->id);

                // Agregasi jumlah kunjungan Wisnu
                $jumlahLakiLaki = $wisnuData->sum('jumlah_laki_laki');
                $jumlahPerempuan = $wisnuData->sum('jumlah_perempuan');

                // Agregasi jumlah kunjungan Wisman
                $jmlWismanLaki = $wismanData->sum('jml_wisman_laki');
                $jmlWismanPerempuan = $wismanData->sum('jml_wisman_perempuan');

                // Tambahkan ke total
                $totalWismanLaki += $jmlWismanLaki;
                $totalWismanPerempuan += $jmlWismanPerempuan;

                // Kelompokkan data berdasarkan kelompok kunjungan dan negara
                $kelompok = $wisnuData->groupBy('kelompok_kunjungan_id');
                $wismanByNegara = $wismanData->groupBy('wismannegara_id');

                // Gabungkan data kunjungan untuk akomodasi
                $kunjungan[] = [
                    'akomodasi' => $akomodasiItem,
                    'jumlah_laki_laki' => $jumlahLakiLaki,
                    'jumlah_perempuan' => $jumlahPerempuan,
                    'kelompok' => $kelompok,
                    'jml_wisman_laki' => $jmlWismanLaki ?: 0,
                    'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
                    'wisman_by_negara' => $wismanByNegara,
                ];
            }

            // Sortir berdasarkan nama akomodasi
            $kunjungan = collect($kunjungan)->sortBy(function($item) {
                return $item['akomodasi']->namaakomodasi; // Mengurutkan berdasarkan nama akomodasi
            });

            // Dapatkan kelompok kunjungan dan negara akomodasiwan mancanegara
            $kelompok = KelompokKunjungan::all();
            $wismannegara = WismanNegara::all();

            return view('admin.kunjunganakomodasi.index', compact(
                'akomodasi', 'kunjungan', 'kategoriAkomodasi', 'kelompok', 'wismannegara', 'hash', 
                'bulan', 'tahun', 'categoryakomodasi_id', 'totalWismanLaki', 'totalWismanPerempuan', 'bulanIndo'
            ));
        }

        public function indexkunjunganakomodasipertahun(Request $request)
        {
            $hash = new Hashids();
            $company_id = auth()->user()->company->id; // Asumsi Anda memiliki data ini
            $akomodasi = Akomodasi::all(); // Data akomodasi untuk dropdown
            
            $tahun = $request->input('tahun', date('Y')); // Default ke tahun sekarang
            $decode = $request->input('akomodasi_id'); // Ambil akomodasi_id dari request, bisa null
            $hash = new Hashids();
            $akomodasi_id = $hash->decode($decode);    
        
            for ($month = 1; $month <= 12; $month++) {
                $startDate = \Carbon\Carbon::create($tahun, $month, 1)->startOfMonth();
                $endDate = \Carbon\Carbon::create($tahun, $month, 1)->endOfMonth();
        
                // Data Akomodasiwan Nusantara (Wisnu)
                $wisnuQuery = WisnuAkomodasi::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                if ($akomodasi_id) {
                    $wisnuQuery->where('akomodasi_id', $akomodasi_id);
                }
                $wisnuKunjungan = $wisnuQuery->get()->groupBy('kelompok_kunjungan_id');
        
                // Data Akomodasiwan Mancanegara (Wisman)
                $wismanQuery = WismanAkomodasi::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                if ($akomodasi_id) {
                    $wismanQuery->where('akomodasi_id', $akomodasi_id);
                }
                $wismanKunjungan = $wismanQuery->get()->groupBy('wismannegara_id');
        
                // Menyusun data kunjungan per bulan
                $kunjungan[$month] = [
                    'jumlah_laki_laki' => $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_laki_laki')) ?? 0,
                    'jumlah_perempuan' => $wisnuKunjungan->sum(fn($data) => $data->sum('jumlah_perempuan')) ?? 0,
                    'kelompok' => $wisnuKunjungan ?? collect(),
                    'jml_wisman_laki' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_laki')) ?? 0,
                    'jml_wisman_perempuan' => $wismanKunjungan->sum(fn($data) => $data->sum('jml_wisman_perempuan')) ?? 0,
                    'wisman_by_negara' => $wismanKunjungan ?? collect(),
                ];
            }
        
            // Data tambahan
            $kelompok = KelompokKunjungan::all();
            $wismannegara = WismanNegara::all();
        
            return view('admin.kunjunganakomodasi.indexkunjunganakomodasipertahun', compact(
                'kunjungan', 'akomodasi', 'kelompok','hash', 'wismannegara', 'tahun', 'akomodasi_id'
            ));
        }
        
        
        

        
        public function indexeditkunjunganakomodasi(Request $request, $akomodasi_id)
        {
            // Membuat instance Hashids untuk enkripsi ID
            $hash = new Hashids();
            
            $akomodasiId = $hash->decode($akomodasi_id);
        
            // Validasi akomodasi berdasarkan ID
            $akomodasi = Akomodasi::find($akomodasiId);
            if (!$akomodasi) {
                return redirect()->route('admin.kunjunganakomodasi.indexkunjunganakomodasipertahun')
                    ->withErrors(['error' => 'Akomodasi tidak ditemukan.']);
            }
        
            // Ambil nilai bulan dan tahun dari request
            $bulan = $request->input('bulan', date('m'));
            $tahun = $request->input('tahun', date('Y'));
        
            // Daftar bulan dalam Bahasa Indonesia
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            // Mendapatkan nama bulan
            $namaBulan = $bulanIndo[(int)$bulan];
            // Menentukan rentang tanggal untuk bulan dan tahun yang dipilih
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
        
            $tanggalRentang = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);


            // Ambil data WisnuAkomodasi berdasarkan akomodasi_id dan rentang tanggal
            $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                ->where('akomodasi_id', $akomodasiId)
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get()
                ->groupBy('tanggal_kunjungan');
        
            // Ambil data WismanAkomodasi berdasarkan akomodasi_id dan rentang tanggal
            $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                ->where('akomodasi_id', $akomodasiId)
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get()
                ->groupBy('tanggal_kunjungan');
        
            // Olah data kunjungan
            $kunjungan = [];
            foreach ($tanggalRentang as $tanggal ) {
                
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
                    'jumlah_laki_laki' => $jumlahLakiLaki,
                    'jumlah_perempuan' => $jumlahPerempuan,
                    'kelompok' => $dataWisnu,
                    'jml_wisman_laki' => $jmlWismanLaki ?: 0,
                    'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
                    'wisman_by_negara' => $wismanByNegara,
                ];
            }
        
            // Urutkan kunjungan berdasarkan tanggal
            $kunjungan = collect($kunjungan)->sortBy(function ($item, $key) {
                return $key;
            });
        
            // Ambil data pendukung untuk tabel
            $kelompok = KelompokKunjungan::all();
            $wismannegara = WismanNegara::all();
        
            // Kembalikan data ke view
            return view('admin.kunjunganakomodasi.indexeditkunjunganakomodasi', [
                'kunjungan' => collect($kunjungan)->sortKeys(),
                'akomodasi' => $akomodasi,
                'kelompok' => $kelompok,
                'wismannegara' => $wismannegara,
                'hash' => $hash,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'bulanIndo' =>$bulanIndo,
            ]);
        }
        

    public function dashboard(Request $request)
            {
                $company_id = auth()->user()->company->id;
                $akomodasi = Akomodasi::all();
                $hash = new Hashids();
                
                // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
                $year = $request->input('year', date('Y'));
            
                // Ambil data kunjungan Wisnu
                $wisnu = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                    ->whereYear('tanggal_kunjungan', $year)
                    ->get()
                    ->groupBy('tanggal_kunjungan');
            
                // Buat array untuk menyimpan data kunjungan per bulan
                $kunjungan = [];
                for ($month = 1; $month <= 12; $month++) {
                    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
                    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();
            
                    // Hitung total kunjungan untuk setiap kategori
                    $totalLakiLaki = WisnuAkomodasi::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_laki_laki');
            
                    $totalPerempuan = WisnuAkomodasi::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_perempuan');
            
                    $totalWismanLaki = WismanAkomodasi::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_laki');
            
                    $totalWismanPerempuan = WismanAkomodasi::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_perempuan');
                    
                    // Ambil data Wisnu dan Wisman berdasarkan bulan
                    $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->get()
                        ->groupBy('kelompok_kunjungan_id');
            
                    $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
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
            
                // Mengelompokkan data berdasarkan kelompok dan menghitung total jumlah laki-laki dan perempuan
                $kelompokData = $kunjungan;
                
                // Kirim data ke view
                return view('admin.kunjunganakomodasi.dashboard', compact(
                    'kunjungan', 'kelompok', 'wismannegara', 'akomodasi', 'hash', 'year', 'totalKeseluruhan', 'kelompokData'
                ));
            }

    public function filterwisnubulan(Request $request)
        {
            {
                $hash = new Hashids();
                $company_id = auth()->user()->company->id;
                $akomodasi = Akomodasi::where('company_id', $company_id)->first();
            
                // Ambil bulan dan tahun dari request (default ke bulan dan tahun saat ini)
                $bulan = $request->input('bulan', date('m')); // Default bulan saat ini
                $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini
            
                // Buat rentang tanggal untuk bulan yang dipilih
                $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
                $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
            
                // Fetch data berdasarkan rentang tanggal
                $wisnuKunjungan = WisnuAkomodasi::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate]) // Filter berdasarkan rentang tanggal
                    ->get()
                    ->groupBy('tanggal_kunjungan');
            
                // Initialize an array to hold all visits data
                $kunjungan = [];
            
                // Populate the kunjungan array with data for each date
                foreach ($wisnuKunjungan as $tanggal => $dataTanggal) {
                    // Convert to collection for easier manipulation
                    $dataTanggal = collect($dataTanggal);
                    $tanggal_kunjungan = $tanggal;
                    // Get the total local visitors
                    $jumlahLakiLaki = $dataTanggal->sum('jumlah_laki_laki');
                    $jumlahPerempuan = $dataTanggal->sum('jumlah_perempuan');
            
                
            
                    $kunjungan[$tanggal] = [
                        'jumlah_laki_laki' => $jumlahLakiLaki,
                        'jumlah_perempuan' => $jumlahPerempuan,
                        'kelompok' => $dataTanggal, // Store the collection for later use
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
            
                return view('admin.kunjunganakomodasi.filterwisnubulan', compact('kunjungan','akomodasi','kelompok', 'hash', 'bulan', 'tahun'));
            }
        }

    public function filterwismanbulan(Request $request)
        {
            {
                $hash = new Hashids();
                $company_id = auth()->user()->company->id;
                $akomodasi = Akomodasi::where('company_id', $company_id)->first();
            
                // Ambil bulan dan tahun dari request (default ke bulan dan tahun saat ini)
                $bulan = $request->input('bulan', date('m')); // Default bulan saat ini
                $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini
            
                // Buat rentang tanggal untuk bulan yang dipilih
                $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
                $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
            
            
            
                $wismanKunjungan = WismanAkomodasi::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate]) // Filter berdasarkan rentang tanggal
                    ->get()
                    ->groupBy('tanggal_kunjungan');
            
                // Initialize an array to hold all visits data
                $kunjungan = [];
            
                // Populate the kunjungan array with data for each date
                foreach ($wismanKunjungan as $tanggal => $dataTanggal) {
                    // Convert to collection for easier manipulation
                    $dataTanggal = collect($dataTanggal);
                    $tanggal_kunjungan = $tanggal;
                    // Get the total local visitors
                    $jmlWismanLaki = $dataTanggal->sum('jml_wisman_laki');
                    $jmlWismanPerempuan = $dataTanggal->sum('jml_wisman_perempuan');
            
                    // Initialize an array to hold foreign visitor counts by country
                    $wismanByNegara = $wismanKunjungan->get($tanggal, collect())->groupBy('wismannegara_id');
            
                    $kunjungan[$tanggal] = [
                        'jml_wisman_laki' => $jmlWismanLaki ?: 0, // Ensure default to 0
                        'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0, // Ensure default to 0
                        'wisman_by_negara' => $dataTanggal, // Store foreign visitor data by country
                    ];
                }
            
                // Convert to a collection for easier manipulation in the view
                $kunjungan = collect($kunjungan);
            
                // Sort kunjungan by date (youngest to oldest)
                $kunjungan = $kunjungan->sortBy(function($item, $key) {
                    return $key; // Sort by the key which is tanggal
                });
            
                // Get kelompok and wisman negara
                $wismannegara = WismanNegara::all();
            
                return view('admin.kunjunganakomodasi.filterwismanbulan', compact('kunjungan','akomodasi', 'wismannegara', 'hash', 'bulan', 'tahun'));
            }
        }

// Menampilkan form input kunjungan
public function createwisnu()
    {
        $company_id = auth()->user()->company->id;
        $kelompok = KelompokKunjungan::all();
        $akomodasi = Akomodasi::all();
        $wismannegara = WismanNegara::all();

        // Define the $tanggal variable, you can set it to the current date or any other logic
        $tanggal = now()->format('d-m-Y'); // This sets $tanggal to today's date in Y-m-d format

        return view('admin.kunjunganakomodasi.create', compact('akomodasi', 'kelompok', 'wismannegara', 'tanggal'));
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
    $decodedAkomodasiId = $hash->decode($akomodasi_id);


    if (!$decodedAkomodasiId) {
        abort(404, 'Akomodasi ID tidak valid');
    }

    // Ambil `company_id` pengguna yang sedang login
    $company_id = auth()->user()->company->id;

    // Ambil data akomodasi
    $akomodasi = Akomodasi::where('id', $decodedAkomodasiId)
        ->first();

    if (!$akomodasi) {
        abort(404, 'Data akomodasi tidak ditemukan');
    }
    

    // Query data WISNU terkait akomodasi dan tanggal kunjungan
    $wisnuData = WisnuAkomodasi::where('akomodasi_id', $decodedAkomodasiId)
        ->where('tanggal_kunjungan', $tanggal_kunjungan)
        ->with('kelompokkunjungan') // Eager loading relasi
        ->get();

    // Query data WISMAN terkait akomodasi dan tanggal kunjungan
    $wismanData = WismanAkomodasi::where('akomodasi_id', $decodedAkomodasiId)
        ->where('tanggal_kunjungan', $tanggal_kunjungan)
        ->with('wismannegara') // Eager loading relasi
        ->get();

    // Aggregate data WISMAN berdasarkan `wismannegara_id`
    $aggregatedWismanData = $wismanData->groupBy('wismannegara_id')->map(function ($group) {
        return [
            'wismannegara_id' => $group->first()->wismannegara_id,
            'jml_wisman_laki' => $group->sum('jml_wisman_laki'),
            'jml_wisman_perempuan' => $group->sum('jml_wisman_perempuan'),
        ];
    });

    // Aggregate data WISNU berdasarkan `kelompok_kunjungan_id`
    $aggregatedWisnuData = $wisnuData->groupBy('kelompok_kunjungan_id')->map(function ($group) {
        return [
            'kelompok_kunjungan_id' => $group->first()->kelompok_kunjungan_id,
            'kelompok_kunjungan_name' => optional($group->first()->kelompokkunjungan)->kelompokkunjungan_name,
            'jumlah_laki_laki' => $group->sum('jumlah_laki_laki'),
            'jumlah_perempuan' => $group->sum('jumlah_perempuan'),
        ];
    });

    // Ambil data kelompok kunjungan dan negara wisman
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();

    // Pass data ke view
    return view('admin.kunjunganakomodasi.edit', compact(
        'wisnuData',
        'hash',
        'aggregatedWismanData',
        'aggregatedWisnuData',
        'tanggal_kunjungan',
        'wismanData',
        'akomodasi',
        'kelompok',
        'wismannegara'
    ));
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
            'wismannegara_id' => 'required|array',
            'jml_wisman_laki' => 'required|array',
            'jml_wisman_perempuan' => 'required|array',
            'jml_wisman_laki.*' => 'required|integer|min:0',
            'jml_wisman_perempuan.*' => 'required|integer|min:0',
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

            // Loop untuk data WISMAN
            foreach ($request->wismannegara_id as $index => $negara) {
                $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];

                WismanAkomodasi::create([
                    'akomodasi_id' => $decodedAkomodasiId,
                    'wismannegara_id' => $negara,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                    'jml_wisman_laki' => $jumlah_wisman_laki,
                    'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                    'updated_at' => now(),
                ]);
            }

            // Commit transaksi
            DB::commit();
            
            // Alihkan ke halaman index dengan pesan sukses
            return redirect()->route('admin.kunjunganakomodasi.index')->with('success', 'Data kunjungan berhasil diperbarui.');

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

            return redirect()->route('admin.kunjunganakomodasi.index')
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

            return redirect()->route('admin.kunjunganakomodasi.index')
                            ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
        }
    }








}

