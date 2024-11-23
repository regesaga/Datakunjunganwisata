<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\WisnuWisata;
use App\Models\CategoryWisata;
use App\Models\KelompokKunjungan;
use App\Models\WismanWisata;
use App\Models\WismanNegara;
use App\Models\Wisata;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Carbon\Carbon; 


class AdminKunjunganWisataController extends Controller
{
    public function indexkunjunganwisata(Request $request)
        {
            $hash = new Hashids();
            $company_id = auth()->user()->company->id;

            // Ambil kategori wisata untuk dropdown
            $kategoriWisata = CategoryWisata::all();

            $categorywisata_id = $request->input('categorywisata_id', null);
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

            // Filter wisata berdasarkan kategori (tampilkan semua jika tidak ada kategori yang dipilih)
            $wisata = Wisata::when($categorywisata_id, function($query) use ($categorywisata_id) {
                return $query->where('categorywisata_id', $categorywisata_id);
            })->get();

            // Tentukan start dan end date sesuai bulan dan tahun
            $startDate = Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();

            // Ambil data kunjungan Wisnu untuk bulan yang dipilih
            $wisnuKunjungan = WisnuWisata::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id', 'wisata_id')
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get();

            // Ambil data kunjungan Wisman untuk bulan yang dipilih
            $wismanKunjungan = WismanWisata::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id', 'wisata_id')
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get();

            // Proses data kunjungan dan wisata
            $kunjungan = [];
            $totalWismanLaki = 0;
            $totalWismanPerempuan = 0;

            foreach ($wisata as $wisataItem) {
                // Ambil data kunjungan untuk ID wisata tertentu
                $wisnuData = $wisnuKunjungan->where('wisata_id', $wisataItem->id);
                $wismanData = $wismanKunjungan->where('wisata_id', $wisataItem->id);

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

                // Gabungkan data kunjungan untuk wisata
                $kunjungan[] = [
                    'wisata' => $wisataItem,
                    'jumlah_laki_laki' => $jumlahLakiLaki,
                    'jumlah_perempuan' => $jumlahPerempuan,
                    'kelompok' => $kelompok,
                    'jml_wisman_laki' => $jmlWismanLaki ?: 0,
                    'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
                    'wisman_by_negara' => $wismanByNegara,
                ];
            }

            // Sortir berdasarkan nama wisata
            $kunjungan = collect($kunjungan)->sortBy(function($item) {
                return $item['wisata']->namawisata; // Mengurutkan berdasarkan nama wisata
            });

            // Dapatkan kelompok kunjungan dan negara wisatawan mancanegara
            $kelompok = KelompokKunjungan::all();
            $wismannegara = WismanNegara::all();

            return view('admin.kunjunganwisata.index', compact(
                'wisata', 'kunjungan', 'kategoriWisata', 'kelompok', 'wismannegara', 'hash', 
                'bulan', 'tahun', 'categorywisata_id', 'totalWismanLaki', 'totalWismanPerempuan', 'bulanIndo'
            ));
        }

        public function indexkunjunganwisatapertahun(Request $request)
        {
            $hash = new Hashids();
            $company_id = auth()->user()->company->id; // Asumsi Anda memiliki data ini
            $wisata = Wisata::all(); // Data wisata untuk dropdown
            
            $tahun = $request->input('tahun', date('Y')); // Default ke tahun sekarang
            $decode = $request->input('wisata_id'); // Ambil wisata_id dari request, bisa null
            $hash = new Hashids();
            $wisata_id = $hash->decode($decode);    
            $wisataTerpilih = $wisata_id ? $wisata->find($wisata_id) : null;

            for ($month = 1; $month <= 12; $month++) {
                $startDate = \Carbon\Carbon::create($tahun, $month, 1)->startOfMonth();
                $endDate = \Carbon\Carbon::create($tahun, $month, 1)->endOfMonth();
        
                // Data Wisatawan Nusantara (Wisnu)
                $wisnuQuery = WisnuWisata::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                if ($wisata_id) {
                    $wisnuQuery->where('wisata_id', $wisata_id);
                }
                $wisnuKunjungan = $wisnuQuery->get()->groupBy('kelompok_kunjungan_id');
        
                // Data Wisatawan Mancanegara (Wisman)
                $wismanQuery = WismanWisata::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                if ($wisata_id) {
                    $wismanQuery->where('wisata_id', $wisata_id);
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
        
            return view('admin.kunjunganwisata.indexkunjunganwisatapertahun', compact(
                'kunjungan', 'wisata', 'kelompok','hash', 'wismannegara', 'tahun', 'wisata_id','wisataTerpilih'
            ));
        }
        
        
        

        
        public function indexeditkunjunganwisata(Request $request, $wisata_id)
        {
            // Membuat instance Hashids untuk enkripsi ID
            $hash = new Hashids();
            
            $wisataId = $hash->decode($wisata_id);
        
            // Validasi wisata berdasarkan ID
            $wisata = Wisata::find($wisataId);
            if (!$wisata) {
                return redirect()->route('admin.kunjunganwisata.indexkunjunganwisatapertahun')
                    ->withErrors(['error' => 'Wisata tidak ditemukan.']);
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


            // Ambil data WisnuWisata berdasarkan wisata_id dan rentang tanggal
            $wisnuKunjungan = WisnuWisata::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                ->where('wisata_id', $wisataId)
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get()
                ->groupBy('tanggal_kunjungan');
        
            // Ambil data WismanWisata berdasarkan wisata_id dan rentang tanggal
            $wismanKunjungan = WismanWisata::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                ->where('wisata_id', $wisataId)
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->get()
                ->groupBy('tanggal_kunjungan');
        
            // Olah data kunjungan
            $kunjungan = [];
            foreach ($tanggalRentang as $tanggal ) {
                
                $tanggalFormat = $tanggal->format('Y-m-d');
                // Ambil data kunjungan dari WisnuWisata
                $dataWisnu = $wisnuKunjungan->get($tanggalFormat, collect());
                $jumlahLakiLaki = $dataWisnu->sum('jumlah_laki_laki');
                $jumlahPerempuan = $dataWisnu->sum('jumlah_perempuan');

                    // Ambil data kunjungan dari WismanWisata
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
            return view('admin.kunjunganwisata.indexeditkunjunganwisata', [
                'kunjungan' => collect($kunjungan)->sortKeys(),
                'wisata' => $wisata,
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
                $wisata = Wisata::all();
                $hash = new Hashids();
                
                // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
                $year = $request->input('year', date('Y'));
            
                // Ambil data kunjungan Wisnu
                $wisnu = WisnuWisata::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                    ->whereYear('tanggal_kunjungan', $year)
                    ->get()
                    ->groupBy('tanggal_kunjungan');
            
                // Buat array untuk menyimpan data kunjungan per bulan
                $kunjungan = [];
                for ($month = 1; $month <= 12; $month++) {
                    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
                    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();
            
                    // Hitung total kunjungan untuk setiap kategori
                    $totalLakiLaki = WisnuWisata::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_laki_laki');
            
                    $totalPerempuan = WisnuWisata::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jumlah_perempuan');
            
                    $totalWismanLaki = WismanWisata::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_laki');
            
                    $totalWismanPerempuan = WismanWisata::whereYear('tanggal_kunjungan', $year)
                        ->whereMonth('tanggal_kunjungan', $month)
                        ->sum('jml_wisman_perempuan');
                    
                    // Ambil data Wisnu dan Wisman berdasarkan bulan
                    $wisnuKunjungan = WisnuWisata::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->get()
                        ->groupBy('kelompok_kunjungan_id');
            
                    $wismanKunjungan = WismanWisata::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
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
            
                // Mengelompokkan data berdasarkan kelompok dan menghitung total jumlah laki-laki dan perempuan
                $kelompokData = $kunjungan;
                
                // Kirim data ke view
                return view('admin.kunjunganwisata.dashboard', compact(
                    'kunjungan', 'kelompok', 'wismannegara', 'wisata', 'hash', 'year', 'totalKeseluruhan', 'kelompokData'
                ));
            }

    public function filterwisnubulan(Request $request)
        {
            {
                $hash = new Hashids();
                $company_id = auth()->user()->company->id;
                $wisata = Wisata::where('company_id', $company_id)->first();
            
                // Ambil bulan dan tahun dari request (default ke bulan dan tahun saat ini)
                $bulan = $request->input('bulan', date('m')); // Default bulan saat ini
                $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini
            
                // Buat rentang tanggal untuk bulan yang dipilih
                $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
                $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
            
                // Fetch data berdasarkan rentang tanggal
                $wisnuKunjungan = WisnuWisata::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
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
            
                return view('admin.kunjunganwisata.filterwisnubulan', compact('kunjungan','wisata','kelompok', 'hash', 'bulan', 'tahun'));
            }
        }

    public function filterwismanbulan(Request $request)
        {
            {
                $hash = new Hashids();
                $company_id = auth()->user()->company->id;
                $wisata = Wisata::where('company_id', $company_id)->first();
            
                // Ambil bulan dan tahun dari request (default ke bulan dan tahun saat ini)
                $bulan = $request->input('bulan', date('m')); // Default bulan saat ini
                $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini
            
                // Buat rentang tanggal untuk bulan yang dipilih
                $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
                $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();
            
            
            
                $wismanKunjungan = WismanWisata::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
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
            
                return view('admin.kunjunganwisata.filterwismanbulan', compact('kunjungan','wisata', 'wismannegara', 'hash', 'bulan', 'tahun'));
            }
        }

// Menampilkan form input kunjungan
public function createwisnu()
    {
        $company_id = auth()->user()->company->id;
        $kelompok = KelompokKunjungan::all();
        $wisata = Wisata::all();
        $wismannegara = WismanNegara::all();

        // Define the $tanggal variable, you can set it to the current date or any other logic
        $tanggal = now()->format('d-m-Y'); // This sets $tanggal to today's date in Y-m-d format

        return view('admin.kunjunganwisata.create', compact('wisata', 'kelompok', 'wismannegara', 'tanggal'));
    }


// Menyimpan data kunjungan
public function storewisnu(Request $request)
{
    // Validasi input
    $request->validate([
        'wisata_id' => 'required',
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
    $existingWisnu = WisnuWisata::where('wisata_id', $request->wisata_id)
        ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->first();

    if ($existingWisnu) {
        // Jika ada, buat notifikasi untuk mengonfirmasi apakah akan mengubah data
        $formattedDate = Carbon::parse($request->tanggal_kunjungan)->format('d-m-Y');
        return redirect()->back()->with('warning', 'Data Kunjungan dengan Tanggal "' . $formattedDate . '" Sudah Di Input. Pilih Tanggal Lain atau Ubah data di menu')
            ->withInput();
    }

    try {
        // Loop untuk data WISNU (Wisatawan Nusantara)
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            WisnuWisata::create([
                'wisata_id' => $request->wisata_id,
                'kelompok_kunjungan_id' => $kelompok, 
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ]);
        }

        // Loop untuk data WISMAN (Wisatawan Mancanegara) hanya jika data tersedia
        if ($request->filled('wismannegara_id') && $request->filled('jml_wisman_laki') && $request->filled('jml_wisman_perempuan')) {
            foreach ($request->wismannegara_id as $index => $negara) {
                $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
                $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];
                WismanWisata::create([
                    'wisata_id' => $request->wisata_id,
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
public function editwisnu($wisata_id, $tanggal_kunjungan)
{

    $hash = new Hashids();

    // Dekripsi `wisata_id`
    $decodedWisataId = $hash->decode($wisata_id);


    if (!$decodedWisataId) {
        abort(404, 'Wisata ID tidak valid');
    }

    // Ambil `company_id` pengguna yang sedang login
    $company_id = auth()->user()->company->id;

    // Ambil data wisata
    $wisata = Wisata::where('id', $decodedWisataId)
        ->first();

    if (!$wisata) {
        abort(404, 'Data wisata tidak ditemukan');
    }
    

    // Query data WISNU terkait wisata dan tanggal kunjungan
    $wisnuData = WisnuWisata::where('wisata_id', $decodedWisataId)
        ->where('tanggal_kunjungan', $tanggal_kunjungan)
        ->with('kelompokkunjungan') // Eager loading relasi
        ->get();

    // Query data WISMAN terkait wisata dan tanggal kunjungan
    $wismanData = WismanWisata::where('wisata_id', $decodedWisataId)
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
    return view('admin.kunjunganwisata.edit', compact(
        'wisnuData',
        'hash',
        'aggregatedWismanData',
        'aggregatedWisnuData',
        'tanggal_kunjungan',
        'wismanData',
        'wisata',
        'kelompok',
        'wismannegara'
    ));
}

public function updatewisnu(Request $request, $tanggal_kunjungan)
    {
        $hash = new Hashids();

        // Decode wisata_id yang dikirim
        $wisata_id_decoded = $hash->decode($request->wisata_id);
        if (empty($wisata_id_decoded)) {
            return redirect()->back()->with('error', 'ID wisata tidak valid.')->withInput($request->all());
        }
        $decodedWisataId = $wisata_id_decoded[0];

        // Validasi input
        $request->validate([
            'wisata_id' => 'required', // Validasi wisata_id sebagai parameter
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
            // Hapus data sebelumnya berdasarkan decoded wisata_id dan tanggal kunjungan
            $deletedWisnu = WisnuWisata::where('wisata_id', $decodedWisataId)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            $deletedWisman = WismanWisata::where('wisata_id', $decodedWisataId)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            Log::info('Previous WISNU and WISMAN data deleted', [
                'deleted_wisnu_count' => $deletedWisnu,
                'deleted_wisman_count' => $deletedWisman,
            ]);

            // Loop untuk data WISNU
            foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
                $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

                WisnuWisata::create([
                    'wisata_id' => $decodedWisataId,
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

                WismanWisata::create([
                    'wisata_id' => $decodedWisataId,
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
            return redirect()->route('admin.kunjunganwisata.index')->with('success', 'Data kunjungan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Mencatat detail kesalahan dengan data yang akan disimpan
            Log::error('Failed to save kunjungan to database.', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'decoded_wisata_id' => $decodedWisataId,
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

    // Menyimpan data kunjungan
public function storewisnuindex(Request $request)
{
    $hash = new Hashids();

    // Decode wisata_id yang dikirim
    $wisata_id_decoded = $hash->decode($request->wisata_id);
    if (empty($wisata_id_decoded)) {
        return redirect()->back()->with('error', 'ID wisata tidak valid.')->withInput($request->all());
    }
    $decodedWisataId = $wisata_id_decoded[0];

    // Validasi input
    $request->validate([
        'wisata_id' => 'required',
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
        // Hapus data sebelumnya berdasarkan wisata_id dan tanggal kunjungan
        $deletedWisnu = WisnuWisata::where('wisata_id', $decodedWisataId)
                                     ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanWisata::where('wisata_id', $decodedWisataId)
                                       ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                       ->delete();

        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

                // Loop untuk data WISNU
            foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
                $jumlah_perempuan = $request->jumlah_perempuan[$kelompok] ?? 0; // Default ke 0 jika tidak ada

                WisnuWisata::create([
                    'wisata_id' => $decodedWisataId,
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

                WismanWisata::create([
                    'wisata_id' => $decodedWisataId,
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

// Fungsi untuk menghapus data kunjungan
public function deletewisnu($wisata_id, $tanggal_kunjungan)
    {
        $hash = new Hashids();
        
        // Dekripsi `wisata_id`
        $wisata_id = $hash->decode($wisata_id)[0] ?? null;

        if (!$wisata_id) {
            abort(404); // Jika `wisata_id` tidak valid, return 404
        }

        try {
            // Mulai transaksi
            DB::beginTransaction();
            
            // Hapus data WISNU berdasarkan wisata_id dan tanggal_kunjungan
            $deletedWisnu = WisnuWisata::where('wisata_id', $wisata_id)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            // Hapus data WISMAN berdasarkan wisata_id dan tanggal_kunjungan
            $deletedWisman = WismanWisata::where('wisata_id', $wisata_id)
                                        ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                        ->delete();

            // Log jumlah data yang dihapus
            Log::info('Deleted WISNU and WISMAN data', [
                'wisata_id' => $wisata_id,
                'tanggal_kunjungan' => $tanggal_kunjungan,
                'deleted_wisnu_count' => $deletedWisnu,
                'deleted_wisman_count' => $deletedWisman,
            ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('admin.kunjunganwisata.index')
                            ->with('success', 'Data kunjungan berhasil dihapus.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();

            // Log error
            Log::error('Failed to delete kunjungan data.', [
                'error_message' => $e->getMessage(),
                'wisata_id' => $wisata_id,
                'tanggal_kunjungan' => $tanggal_kunjungan,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('admin.kunjunganwisata.index')
                            ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
        }
    }








}

