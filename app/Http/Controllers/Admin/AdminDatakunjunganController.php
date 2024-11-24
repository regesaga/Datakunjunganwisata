<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\KelompokKunjungan;
use App\Models\WismanNegara;
use AApp\Models\CategoryAkomodasi;
use App\Models\CategoryWisata;
use App\Models\CategoryKuliner;
use App\Models\Akomodasi;
use App\Models\Wisata;
use App\Models\Kuliner;
use App\Models\WismanAkomodasi;
use App\Models\WismanWisata;
use App\Models\WismanKuliner;
use App\Models\WisnuKuliner;
use App\Models\WisnuWisata;
use App\Models\WisnuAkomodasi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Carbon\Carbon; 


class AdminDatakunjunganController extends Controller
{
    public function index(Request $request)
        {
            $company_id = auth()->user()->company->id;
            $hash = new Hashids();
            $wisata = Wisata::all(); // Mendapatkan wisata terkait
            $kuliner = Kuliner::all(); // Mendapatkan kuliner terkait
            $akomodasi = Akomodasi::all(); // Mendapatkan akomodasi terkait
        
            // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
            $year = $request->input('year', date('Y'));
            
            // Buat array untuk menyimpan data kunjungan per bulan
            $kunjungan = [];
        
            for ($month = 1; $month <= 12; $month++) {
                $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-01-01")->startOfYear();
                $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$year}-12-31")->endOfYear();
        
                // Fungsi helper untuk menghitung total kunjungan by objek
                $totalWisata = $this->sumKunjungan('wisnuwisata', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnuwisata', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wismanwisata', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wismanwisata', $year, $month, 'jml_wisman_perempuan');
                
                $totalKuliner = $this->sumKunjungan('wisnukuliner', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnukuliner', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wismankuliner', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wismankuliner', $year, $month, 'jml_wisman_perempuan');
        
                $totalAkomodasi = $this->sumKunjungan('wisnuakomodasi', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnuakomodasi', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wismanakomodasi', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wismanakomodasi', $year, $month, 'jml_wisman_perempuan');
        
                // Fungsi helper untuk menghitung total kunjungan
                $totalLakiLakiWisnu = $this->sumKunjungan('wisnuwisata', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnuakomodasi', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnukuliner', $year, $month, 'jumlah_laki_laki');
        
                $totalPerempuanWisnu = $this->sumKunjungan('wisnuwisata', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wisnuakomodasi', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wisnukuliner', $year, $month, 'jumlah_perempuan');
        
                $totalWismanLaki = $this->sumKunjungan('wismanwisata', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wismanakomodasi', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wismankuliner', $year, $month, 'jml_wisman_laki');
        
                $totalWismanPerempuan = $this->sumKunjungan('wismanwisata', $year, $month, 'jml_wisman_perempuan')
                    + $this->sumKunjungan('wismanakomodasi', $year, $month, 'jml_wisman_perempuan')
                    + $this->sumKunjungan('wismankuliner', $year, $month, 'jml_wisman_perempuan');
        
                    $wisnuKunjungan = DB::table(function ($query) use ($startDate, $endDate) {
                        $query->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                            ->from('wisnuwisata')
                            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            ->unionAll(
                                DB::table('wisnuakomodasi')
                                    ->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            )
                            ->unionAll(
                                DB::table('wisnukuliner')
                                    ->selectRaw('kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            );
                    })->get()
                      ->groupBy('kelompok_kunjungan_id'); // Grouping the result after fetching it.
                    
                                        
                      $wismanKunjungan = DB::table(function ($query) use ($startDate, $endDate) {
                        $query->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan') // Corrected selectRaw syntax
                            ->from('wismanwisata')
                            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            ->unionAll(
                                DB::table('wismanakomodasi')
                                    ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan') // Corrected selectRaw syntax
                                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            )
                            ->unionAll(
                                DB::table('wismankuliner')
                                    ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan') // Corrected selectRaw syntax
                                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            );
                    })->get()
                      ->groupBy('wismannegara_id'); // Grouping the result after fetching the data
                    
            
                                        // Simpan data kunjungan per bulan
                                        $kunjungan[$month] = [
                                            'totalkunjunganWisata' => $totalWisata,
                                            'totalkunjunganKuliner' => $totalKuliner,
                                            'totalkunjunganAkomodasi' => $totalAkomodasi,
                                            'total_laki_laki' => $totalLakiLakiWisnu,
                                            'total_perempuan' => $totalPerempuanWisnu,
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
            
                                    // Hitung total keseluruhan per tahun
                                    $totalKeseluruhan = [
                                        'totalkunjunganWisata' => array_sum(array_column($kunjungan, 'totalkunjunganWisata')),
                                        'totalkunjunganKuliner' => array_sum(array_column($kunjungan, 'totalkunjunganKuliner')),
                                        'totalkunjunganAkomodasi' => array_sum(array_column($kunjungan, 'totalkunjunganAkomodasi')),
                                        'total_laki_laki' => array_sum(array_column($kunjungan, 'total_laki_laki')),
                                        'total_perempuan' => array_sum(array_column($kunjungan, 'total_perempuan')),
                                        'total_wisman_laki' => array_sum(array_column($kunjungan, 'total_wisman_laki')),
                                        'total_wisman_perempuan' => array_sum(array_column($kunjungan, 'total_wisman_perempuan')),
                                    ];
            
                                    // Data untuk grafik atau tabel
                                    $bulan = [];
                                    $totalKunjungan = [];
                                // Hitung jumlah laki-laki dan perempuan per kelompok
                                $wisnuKunjunganArray = $wisnuKunjungan->toArray();
                                $wismanKunjunganArray = $wismanKunjungan->toArray();

                                // Hitung jumlah laki-laki dan perempuan per kelompok
                                $kelompokData = [];
            
                                foreach ($wisnuKunjungan as $kelompokId => $dataKelompok) {
                                    $jumlahLakiLaki = 0;
                                    $jumlahPerempuan = 0;
            
                                    // Menghitung total jumlah laki-laki dan perempuan untuk masing-masing kelompok
                                    foreach ($dataKelompok as $data) {
                                        $jumlahLakiLaki += $data->jumlah_laki_laki;
                                        $jumlahPerempuan += $data->jumlah_perempuan;
                                    }
            
                                    // Menyimpan nama kelompok dari database menggunakan kelompokId
                                    $kelompokName = DB::table('kelompokKunjungan')
                                        ->where('id', $kelompokId)
                                        ->value('kelompokkunjungan_name'); // Ambil nama kelompok berdasarkan ID
            
                                    // Menyimpan hasil perhitungan
                                    $kelompokData[] = [
                                        'kelompok_id' => $kelompokId,
                                        'name' => $kelompokName, // Menggunakan nama yang didapatkan dari query
                                        'jumlah_laki_laki' => $jumlahLakiLaki,
                                        'jumlah_perempuan' => $jumlahPerempuan
                                    ];
                                }
                                
            
            
                                $negaraData = [];
            
                                foreach ($wismanKunjungan as $NegaraId => $dataNegara) {
                                    $jmlwismanLaki = 0;
                                    $jmlwismanPerempuan = 0;
           
                                    // Menghitung total jumlah laki-laki dan perempuan untuk masing-masing kelompok
                                    foreach ($dataNegara as $data) {
                                        $jmlwismanLaki += $data->jml_wisman_laki;
                                        $jmlwismanPerempuan += $data->jml_wisman_perempuan;
                                    }
           
                                    // Menyimpan nama kelompok dari database menggunakan NegaraId
                                    $negaraName = DB::table('wismannegara')
                                        ->where('id', $NegaraId)
                                        ->value('wismannegara_name'); // Ambil nama kelompok berdasarkan ID
           
                                    // Menyimpan hasil perhitungan
                                    $negaraData[] = [
                                        'wismannegara_id' => $NegaraId,
                                        'name' => $negaraName, // Menggunakan nama yang didapatkan dari query
                                        'jml_wisman_laki' => $jmlwismanLaki,
                                        'jml_wisman_perempuan' => $jmlwismanPerempuan
                                    ];
                                }

                                
                                // Check if $negaraData is populated


                                

                        foreach ($kunjungan as $month => $dataBulan) {
                            $bulan[] = \Carbon\Carbon::createFromFormat('!m', $month)->format('F');  // Nama bulan
                            $totalKunjungan[] = $dataBulan['total_laki_laki'] + $dataBulan['total_perempuan'] + 
                                                $dataBulan['total_wisman_laki'] + $dataBulan['total_wisman_perempuan'];  // Total kunjungan
                            $totalKunjunganLaki[] = $dataBulan['total_laki_laki'] + $dataBulan['total_wisman_laki'] ;  // Total  LakiLaki
                            $totalKunjunganPerempuan[] = $dataBulan['total_perempuan'] + $dataBulan['total_wisman_perempuan'] ;  // Total  LakiLaki
                            $totalWisataAll[] = $dataBulan['totalkunjunganWisata'];  // Total  LakiLaki
                            $totalKulinerAll[] = $dataBulan['totalkunjunganKuliner'];  // Total  LakiLaki
                            $totalAkomodasiAll[] = $dataBulan['totalkunjunganAkomodasi'];  // Total  LakiLaki
                        
                    }

            return view('admin.datakunjungan.index', compact('negaraData',
                'kunjungan', 'kelompok','kelompokData','wismannegara', 'wisata', 'hash', 'year', 'totalKeseluruhan','bulan', 'totalKunjungan','totalKunjunganLaki','totalKunjunganPerempuan','totalWisataAll','totalKulinerAll','totalAkomodasiAll'
            ));
        }


/**
 * Helper function to calculate total visits.
 */
private function sumKunjungan($table, $year, $month, $column, $wisata_id = null)
{
    $query = DB::table($table)
        ->whereYear('tanggal_kunjungan', $year)
        ->whereMonth('tanggal_kunjungan', $month);

    if ($wisata_id) {
        $query->where('wisata_id', $wisata_id);
    }

    return $query->sum($column);
}

public function semua(Request $request)
{
    // Mendapatkan kategori dan tahun dari request
    $kategori = $request->get('kategori', 'semua'); // Default kategori 'semua'
    $tahun = $request->get('tahun', date('Y')); // Default tahun adalah tahun sekarang

    // Mengambil semua kelompok dan negara untuk ditampilkan di table
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();

    // Menentukan variabel yang selalu tersedia untuk compact
    $wisata = null;
    $akomodasi = null;
    $kuliner = null;
    $kunjungan = [];

    // Filter data berdasarkan kategori yang dipilih
    if ($kategori === 'wisata') {
        $wisata = Wisata::all(); // Menampilkan data wisata
        $kunjungan = $this->getKunjunganWisata($tahun);
    } elseif ($kategori === 'akomodasi') {
        $akomodasi = Akomodasi::all(); // Menampilkan data akomodasi
        $kunjungan = $this->getKunjunganAkomodasi($tahun);
    } elseif ($kategori === 'kuliner') {
        $kuliner = Kuliner::all(); // Menampilkan data kuliner
        $kunjungan = $this->getKunjunganKuliner($tahun);
    } else {
        $wisata = Wisata::all(); // Default jika kategori 'semua'
        $akomodasi = Akomodasi::all();
        $kuliner = Kuliner::all();
        $kunjungan = $this->getKunjunganSemua($tahun);
    }
    

    // Mengirim data ke view
    return view('admin.datakunjungan.semua', compact('kunjungan', 'kelompok', 'wismannegara', 'kategori', 'tahun', 'wisata', 'akomodasi', 'kuliner'));
}


private function getKunjunganWisata($tahun)
{

    for ($month = 1; $month <= 12; $month++) {
        $startDate = \Carbon\Carbon::create($tahun, $month, 1)->startOfMonth();
        $endDate = \Carbon\Carbon::create($tahun, $month, 1)->endOfMonth();

        $wisnuQuery = WisnuWisata::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
        $wisnuKunjungan = $wisnuQuery->get()->groupBy('kelompok_kunjungan_id');

        // Data Wisatawan Mancanegara (Wisman)
        $wismanQuery = WismanWisata::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
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

    return $kunjungan;
}

private function getKunjunganAkomodasi($tahun)
{

    for ($month = 1; $month <= 12; $month++) {
        $startDate = \Carbon\Carbon::create($tahun, $month, 1)->startOfMonth();
        $endDate = \Carbon\Carbon::create($tahun, $month, 1)->endOfMonth();

        // Fetch and group data in a single query
        $wisnuQuery = WisnuAkomodasi::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
        $wisnuKunjungan = $wisnuQuery->get()->groupBy('kelompok_kunjungan_id');

        // Data Akomodasiwan Mancanegara (Wisman)
        $wismanQuery = WismanAkomodasi::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
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

    return $kunjungan;
}

private function getKunjunganKuliner($tahun)
{

    for ($month = 1; $month <= 12; $month++) {
        $startDate = \Carbon\Carbon::create($tahun, $month, 1)->startOfMonth();
        $endDate = \Carbon\Carbon::create($tahun, $month, 1)->endOfMonth();

        $wisnuQuery = WisnuKuliner::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
        $wisnuKunjungan = $wisnuQuery->get()->groupBy('kelompok_kunjungan_id');

        // Data Kulinerwan Mancanegara (Wisman)
        $wismanQuery = WismanKuliner::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
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

    return $kunjungan;
}

private function getKunjunganSemua($tahun)
{
    $kunjungan = []; // Array untuk menyimpan hasil akhir

    for ($month = 1; $month <= 12; $month++) {
        // Tentukan rentang tanggal untuk bulan tertentu
        $startDate = \Carbon\Carbon::create($tahun, $month, 1)->startOfMonth();
        $endDate = \Carbon\Carbon::create($tahun, $month, 1)->endOfMonth();

        // Query untuk data kunjungan Wisnu
        $wisnuKunjungan = DB::table(function ($query) use ($startDate, $endDate) {
            $query->selectRaw('kelompok_kunjungan_id, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan')
                ->from('wisnuwisata')
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->groupBy('kelompok_kunjungan_id')
                ->unionAll(
                    DB::table('wisnuakomodasi')
                        ->selectRaw('kelompok_kunjungan_id, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan')
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->groupBy('kelompok_kunjungan_id')
                )
                ->unionAll(
                    DB::table('wisnukuliner')
                        ->selectRaw('kelompok_kunjungan_id, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan')
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->groupBy('kelompok_kunjungan_id')
                );
        })
        ->selectRaw('kelompok_kunjungan_id, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan')
        ->groupBy('kelompok_kunjungan_id')
        ->get();
        
        $wismanKunjungan = DB::table(function ($query) use ($startDate, $endDate) {
            $query->selectRaw('wismannegara_id, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan')
                ->from('wismanwisata')
                ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->groupBy('wismannegara_id')
                ->unionAll(
                    DB::table('wismanakomodasi')
                        ->selectRaw('wismannegara_id, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan')
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->groupBy('wismannegara_id')
                )
                ->unionAll(
                    DB::table('wismankuliner')
                        ->selectRaw('wismannegara_id, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan')
                        ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                        ->groupBy('wismannegara_id')
                );
        })
        ->selectRaw('wismannegara_id, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan')
        ->groupBy('wismannegara_id')
        ->get();
        
        // Proses hasil untuk setiap kelompok kunjungan
        $kunjungan[$month] = [
            'jumlah_laki_laki' => $wisnuKunjungan->sum(fn($data) => $data->jumlah_laki_laki),
            'jumlah_perempuan' => $wisnuKunjungan->sum(fn($data) => $data->jumlah_perempuan),
            'kelompok' => $wisnuKunjungan->groupBy('kelompok_kunjungan_id'),
            'jml_wisman_laki' => $wismanKunjungan->sum(fn($data) => $data->jml_wisman_laki),
            'jml_wisman_perempuan' => $wismanKunjungan->sum(fn($data) => $data->jml_wisman_perempuan),
            'wisman_by_negara' => $wismanKunjungan->groupBy('wismannegara_id'),
        ];
    }

    return $kunjungan; // Return hasil akhir
}




}

