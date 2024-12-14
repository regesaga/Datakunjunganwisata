<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\KelompokKunjungan;
use App\Models\WismanNegara;
use App\Models\TargetKunjungan;
use AApp\Models\CategoryAkomodasi;
use App\Models\CategoryWisata;
use App\Models\CategoryKuliner;
use App\Models\Akomodasi;
use App\Models\Wisata;
use App\Models\Evencalender;
use App\Models\Kuliner;
use App\Models\User;
use App\Models\Company;
use App\Models\WisnuEvent;
use App\Models\WismanEvent;
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
use Illuminate\Support\Facades\Auth;



class AdminDatakunjunganController extends Controller
{
    public function index(Request $request)
        {
            $company_id = auth()->user()->company->id;
            $hash = new Hashids();
            $wisata = Wisata::all(); // Mendapatkan wisata terkait
            $kuliner = Kuliner::all(); // Mendapatkan kuliner terkait
            $akomodasi = Akomodasi::all(); // Mendapatkan akomodasi terkait
            $events = Evencalender::all();
            $company = Company::pluck('id');
            // Ambil tahun dari request atau gunakan tahun saat ini jika tidak ada input
            $year = $request->input('year', date('Y'));
            
            $targetKunjungan = TargetKunjungan::getTargetPerYear($year);
            // Buat array untuk menyimpan data kunjungan per bulan
            $kunjungan = [];
            $companyIds = Company::pluck('id'); // Ambil semua ID perusahaan
            $jumlah_userwisata = Wisata::whereIn('company_id', $companyIds)->count();
            $jumlah_userkuliner = Kuliner::whereIn('company_id', $companyIds)->count();
            $jumlah_userakomodasi = Akomodasi::whereIn('company_id', $companyIds)->count();

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

                $totalEvent = $this->sumKunjungan('wisnu_event', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnu_event', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wisman_event', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wisman_event', $year, $month, 'jml_wisman_perempuan');
        
                // Fungsi helper untuk menghitung total kunjungan
                $totalLakiLakiWisnu = $this->sumKunjungan('wisnuwisata', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnuakomodasi', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnukuliner', $year, $month, 'jumlah_laki_laki')
                    + $this->sumKunjungan('wisnu_event', $year, $month, 'jumlah_laki_laki');
        
                $totalPerempuanWisnu = $this->sumKunjungan('wisnuwisata', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wisnuakomodasi', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wisnukuliner', $year, $month, 'jumlah_perempuan')
                    + $this->sumKunjungan('wisnu_event', $year, $month, 'jumlah_perempuan');
        
                $totalWismanLaki = $this->sumKunjungan('wismanwisata', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wismanakomodasi', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wismankuliner', $year, $month, 'jml_wisman_laki')
                    + $this->sumKunjungan('wisman_event', $year, $month, 'jml_wisman_laki');
        
                $totalWismanPerempuan = $this->sumKunjungan('wismanwisata', $year, $month, 'jml_wisman_perempuan')
                    + $this->sumKunjungan('wismanakomodasi', $year, $month, 'jml_wisman_perempuan')
                    + $this->sumKunjungan('wismankuliner', $year, $month, 'jml_wisman_perempuan')
                    + $this->sumKunjungan('wisman_event', $year, $month, 'jml_wisman_perempuan');
        
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
                                DB::table('wisnu_event')
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
                                DB::table('wisman_event')
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
                                            'totalkunjunganEvent' => $totalEvent,
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
                                        'totalkunjunganEvent' => array_sum(array_column($kunjungan, 'totalkunjunganEvent')),
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
                            $totalEventAll[] = $dataBulan['totalkunjunganEvent'];  // Total  LakiLaki
                        
                    }

   // Ambil data target kunjungan per bulan untuk tahun yang diminta
   $targetKunjungan = TargetKunjungan::getTargetPerYear($year);

   // Array untuk menampung data kunjungan
   $semuakunjungan = [];

   foreach ($targetKunjungan as $target) {
       $bulann = $target->bulan;

       // Total kunjungan per bulan dari berbagai tabel
       $totalKunjungan = WisnuWisata::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                         WisnuWisata::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                         WismanWisata::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_laki') +
                         WismanWisata::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                         WisnuKuliner::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                         WisnuKuliner::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                         WismanKuliner::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                         WismanKuliner::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                         WisnuAkomodasi::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                         WisnuAkomodasi::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                         WismanAkomodasi::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                         WismanAkomodasi::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                         WisnuEvent::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                         WisnuEvent::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                         WismanEvent::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                         WismanEvent::whereMonth('tanggal_kunjungan', $bulann)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan');

       // Menambahkan data perbandingan target dan realisasi kunjungan
       $semuakunjungan[] = [
           'bulann' => $bulann,
           'target' => $target->target_kunjungan_wisata,
           'realisasi' => $totalKunjungan,
           'selisih' => $totalKunjungan - $target->target_kunjungan_wisata
       ];
   }


            return view('admin.datakunjungan.index', compact('negaraData','jumlah_userwisata','jumlah_userakomodasi','jumlah_userkuliner','semuakunjungan',
               'bulann','kunjungan', 'kelompok','kelompokData','wismannegara', 'wisata', 'hash', 'year', 'totalKeseluruhan','bulan', 'totalKunjungan','totalKunjunganLaki','totalKunjunganPerempuan','totalWisataAll','totalKulinerAll','totalAkomodasiAll','totalEventAll'
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
    $event = null;
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
    } elseif ($kategori === 'event') {
        $event = Evencalender::all(); // Menampilkan data event
        $kunjungan = $this->getKunjunganEvent($tahun);
    } else {
        $wisata = Wisata::all(); // Default jika kategori 'semua'
        $akomodasi = Akomodasi::all();
        $kuliner = Kuliner::all();
        $event = Evencalender::all();
        $kunjungan = $this->getKunjunganSemua($tahun);
    }
    

    // Mengirim data ke view
    return view('admin.datakunjungan.semua', compact('kunjungan', 'kelompok', 'wismannegara', 'kategori', 'tahun', 'wisata', 'akomodasi', 'kuliner','event'));
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

private function getKunjunganEvent($tahun)
{

    for ($month = 1; $month <= 12; $month++) {
        $startDate = \Carbon\Carbon::create($tahun, $month, 1)->startOfMonth();
        $endDate = \Carbon\Carbon::create($tahun, $month, 1)->endOfMonth();

        $wisnuQuery = WisnuEvent::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
        $wisnuKunjungan = $wisnuQuery->get()->groupBy('kelompok_kunjungan_id');

        // Data Eventwan Mancanegara (Wisman)
        $wismanQuery = WismanEvent::whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
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
                    DB::table('wisnu_event')
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
                    DB::table('wisman_event')
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


public function semuabulan(Request $request)
{
    $kategori = $request->get('kategori', 'semua'); // Default ke 'semua' jika tidak ada kategori dipilih
    $tahun = $request->get('tahun');
    $bulan = $request->get('bulan');

    // Daftar bulan dalam Bahasa Indonesia
    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();
    // Mendapatkan awal dan akhir bulan
    $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
    $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

    $wisataList = null;
    $kulinerList = null;
    $akomodasiList = null;
    $eventList = null;
    $kunjungan = [];
    $totalWismanLaki = 0;
    $totalWismanPerempuan = 0;

    if ($kategori === 'semua') {
        $wisataList = Wisata::with([
            'wisnuWisata' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            },
            'wismanWisata' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            }
        ])->get();

        $kulinerList = Kuliner::with([
            'wisnuKuliner' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            },
            'wismanKuliner' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            }
        ])->get();

        $akomodasiList = Akomodasi::with([
            'wisnuAkomodasi' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            },
            'wismanAkomodasi' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            }
        ])->get();
        $eventList = Evencalender::with([
            'wisnuEvent' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            },
            'wismanEvent' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
            }
        ])->get();
    } else {
        switch ($kategori) {
            case 'wisata':
                $wisataList = Wisata::with([
                    'wisnuWisata' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                    },
                    'wismanWisata' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                    }
                ])->get();
                break;
            case 'kuliner':
                $kulinerList = Kuliner::with([
                    'wisnuKuliner' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                    },
                    'wismanKuliner' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                    }
                ])->get();
                break;
            case 'event':
                $eventList = Evencalender::with([
                    'wisnuEvent' => function ($query) use ($startDate, $endDate) {
                            $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                        },
                    'wismanEvent' => function ($query) use ($startDate, $endDate) {
                            $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                        }
                ])->get();
                break;
            case 'akomodasi':
                $akomodasiList = Akomodasi::with([
                    'wisnuAkomodasi' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                    },
                    'wismanAkomodasi' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                    }
                ])->get();
                break;
        }
    }

    // Fungsi untuk memproses data
    $processData = function ($item, $wisnuRelation, $wismanRelation) use (&$kunjungan, &$totalWismanLaki, &$totalWismanPerempuan) {
        $wisnu = $item->$wisnuRelation;
        $wisman = $item->$wismanRelation;

        // Agregasi jumlah kunjungan Wisnu
        $jumlahLakiLaki = $wisnu->sum('jumlah_laki_laki');
        $jumlahPerempuan = $wisnu->sum('jumlah_perempuan');

        // Agregasi jumlah kunjungan Wisman
        $jmlWismanLaki = $wisman->sum('jml_wisman_laki');
        $jmlWismanPerempuan = $wisman->sum('jml_wisman_perempuan');

        // Tambahkan ke total
        $totalWismanLaki += $jmlWismanLaki;
        $totalWismanPerempuan += $jmlWismanPerempuan;

        // Kelompokkan data berdasarkan kelompok kunjungan dan negara
        $kelompok = $wisnu->groupBy('kelompok_kunjungan_id');
        $wismannegara = $wisman->groupBy('wismannegara_id');

        // Gabungkan data kunjungan
        $kunjungan[] = [
            'item' => $item,
            'jumlah_laki_laki' => $jumlahLakiLaki,
            'jumlah_perempuan' => $jumlahPerempuan,
            'kelompok' => $kelompok,
            'jml_wisman_laki' => $jmlWismanLaki ?: 0,
            'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
            'wismannegara' => $wismannegara,
        ];
    };

    // Proses data Wisata
    if ($wisataList) {
        foreach ($wisataList as $wisataItem) {
            $processData($wisataItem, 'wisnuWisata', 'wismanWisata');
        }
    }

    // Proses data Kuliner
    if ($kulinerList) {
        foreach ($kulinerList as $kulinerItem) {
            $processData($kulinerItem, 'wisnuKuliner', 'wismanKuliner');
        }
    }

    // Proses data Event
    if ($eventList) {
        foreach ($eventList as $eventItem) {
            $processData($eventItem, 'wisnuEvent', 'wismanEvent');
        }
    }

    // Proses data Akomodasi
    if ($akomodasiList) {
        foreach ($akomodasiList as $akomodasiItem) {
            $processData($akomodasiItem, 'wisnuAkomodasi', 'wismanAkomodasi');
        }
    }

    // Kembalikan data ke view
    return view('admin.datakunjungan.semuabulan', compact(
        'kategori', 'tahun', 'bulan', 'bulanIndo', 
        'wisataList', 'kulinerList', 'akomodasiList', 'eventList',
        'kunjungan', 'totalWismanLaki', 'totalWismanPerempuan','kelompok','wismannegara'
    ));
}


public function indexkunjunganeventpertahun(Request $request)
{
    $hash = new Hashids();
    $userId = Auth::id();

    // Mengambil semua event berdasarkan created_by_id
    $events = Evencalender::all();  // Ambil semua event
    
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

    return view('admin.kunjunganevent.indexkunjunganeventpertahun', compact(
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
    $event = Evencalender::all(); // Ambil semua event

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
    return view('admin.kunjunganevent.create', compact('event', 'kelompok', 'wismannegara', 'tanggal_kunjungan'));
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
        // Loop untuk data WISNU (Wisatawan Nusantara)
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

        // Loop untuk data WISMAN (Wisatawan Mancanegara) hanya jika data tersedia
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

    // Decode wisata_id yang dikirim
    $event_calender_id_decoded = $hash->decode($request->event_calender_id);
    if (empty($event_calender_id_decoded)) {
        Log::error('Failed to decode event_calendar_id.', [
            'event_calender_id' => $request->event_calender_id
        ]);
        return redirect()->back()->with('error', 'ID wisata tidak valid.')->withInput($request->all());
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
    // $wisata = Wisata::where('company_id', $company_id)->first();
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
    return view('admin.kunjunganevent.edit', compact('wisnuData', 'hash','aggregatedWismanData','aggregatedWisnuData','tanggal_kunjungan','wismanData', 'event', 'kelompok', 'wismannegara', 'hash'));
}

public function updatewisnuevent(Request $request, $tanggal_kunjungan)
{
    $hash = new Hashids();

    // Decode event_calendar_id yang dikirim
    $event_calendar_id_decoded = $hash->decode($request->event_calendar_id);
    if (empty($event_calendar_id_decoded)) {
        return redirect()->back()->with('error', 'ID wisata tidak valid.')->withInput($request->all());
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
        return redirect()->route('admin.kunjunganevent.indexkunjunganeventpertahun')->with('success', 'Data kunjungan berhasil diperbarui.');

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

        return redirect()->route('admin.kunjunganevent.indexkunjunganeventpertahun')
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

        return redirect()->route('admin.kunjunganevent.indexkunjunganeventpertahun')
                         ->with('error', 'Gagal menghapus data kunjungan. Silakan coba lagi.');
    }
}




public function realtime(Request $request)
{
    $hash = new Hashids();
        // Mengambil semua kelompok dan negara untuk ditampilkan di table
        $kelompok = KelompokKunjungan::all();
        $wismannegara = WismanNegara::all();

        // Menentukan variabel yang selalu tersedia untuk compact
        $wisata = null;
        $akomodasi = null;
        $kuliner = null;
        $event = null;
        $kunjungan = [];

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


    


    // Query untuk kunjungan Wisnu
    $wisnuKunjungan = DB::table(function ($query) use ($startDate, $endDate) {
        $query->selectRaw('tanggal_kunjungan, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan, kelompok_kunjungan_id')
            ->from('wisnuwisata')
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->groupBy('tanggal_kunjungan', 'kelompok_kunjungan_id')
            ->unionAll(
                DB::table('wisnuakomodasi')
                    ->selectRaw('tanggal_kunjungan, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan, kelompok_kunjungan_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->groupBy('tanggal_kunjungan', 'kelompok_kunjungan_id')
            )
            ->unionAll(
                DB::table('wisnu_event')
                    ->selectRaw('tanggal_kunjungan, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan, kelompok_kunjungan_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->groupBy('tanggal_kunjungan', 'kelompok_kunjungan_id')
            )
            ->unionAll(
                DB::table('wisnukuliner')
                    ->selectRaw('tanggal_kunjungan, SUM(jumlah_laki_laki) as jumlah_laki_laki, SUM(jumlah_perempuan) as jumlah_perempuan, kelompok_kunjungan_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->groupBy('tanggal_kunjungan', 'kelompok_kunjungan_id')
            );
    })
    ->select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
    ->get()
    ->groupBy('tanggal_kunjungan');

    // Query untuk kunjungan Wisman
    $wismanKunjungan = DB::table(function ($query) use ($startDate, $endDate) {
        $query->selectRaw('tanggal_kunjungan, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan, wismannegara_id')
            ->from('wismanwisata')
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->groupBy('tanggal_kunjungan', 'wismannegara_id')
            ->unionAll(
                DB::table('wismanakomodasi')
                    ->selectRaw('tanggal_kunjungan, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan, wismannegara_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->groupBy('tanggal_kunjungan', 'wismannegara_id')
            )
            ->unionAll(
                DB::table('wisman_event')
                    ->selectRaw('tanggal_kunjungan, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan, wismannegara_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->groupBy('tanggal_kunjungan', 'wismannegara_id')
            )
            ->unionAll(
                DB::table('wismankuliner')
                    ->selectRaw('tanggal_kunjungan, SUM(jml_wisman_laki) as jml_wisman_laki, SUM(jml_wisman_perempuan) as jml_wisman_perempuan, wismannegara_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->groupBy('tanggal_kunjungan', 'wismannegara_id')
            );
    })
    ->select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
    ->get()
    ->groupBy('tanggal_kunjungan');

    // Olah data kunjungan
    foreach ($tanggalRentang as $tanggal) {
        $tanggalFormat = $tanggal->format('Y-m-d');
    
        // Ambil data kunjungan berdasarkan tanggal untuk Wisnu
        $dataWisnu = $wisnuKunjungan->get($tanggalFormat, collect());
        $jumlahLakiLaki = $dataWisnu->sum('jumlah_laki_laki');
        $jumlahPerempuan = $dataWisnu->sum('jumlah_perempuan');
        $wisnuByKelompok = $dataWisnu->groupBy('kelompok_kunjungan_id');
    
        // Ambil data kunjungan berdasarkan tanggal untuk Wisman
        $dataWisman = $wismanKunjungan->get($tanggalFormat, collect());
        $jmlWismanLaki = $dataWisman->sum('jml_wisman_laki');
        $jmlWismanPerempuan = $dataWisman->sum('jml_wisman_perempuan');
        $wismanByNegara = $dataWisman->groupBy('wismannegara_id');
    
        // Hitung total kunjungan per objek berdasarkan tanggal
        $totalWisata = $this->sumKunjunganrealtime('wisnuwisata', $tanggalFormat, 'jumlah_laki_laki')
            + $this->sumKunjunganrealtime('wisnuwisata', $tanggalFormat, 'jumlah_perempuan')
            + $this->sumKunjunganrealtime('wismanwisata', $tanggalFormat, 'jml_wisman_laki')
            + $this->sumKunjunganrealtime('wismanwisata', $tanggalFormat, 'jml_wisman_perempuan');
    
        $totalKuliner = $this->sumKunjunganrealtime('wisnukuliner', $tanggalFormat, 'jumlah_laki_laki')
            + $this->sumKunjunganrealtime('wisnukuliner', $tanggalFormat, 'jumlah_perempuan')
            + $this->sumKunjunganrealtime('wismankuliner', $tanggalFormat, 'jml_wisman_laki')
            + $this->sumKunjunganrealtime('wismankuliner', $tanggalFormat, 'jml_wisman_perempuan');
    
        $totalAkomodasi = $this->sumKunjunganrealtime('wisnuakomodasi', $tanggalFormat, 'jumlah_laki_laki')
            + $this->sumKunjunganrealtime('wisnuakomodasi', $tanggalFormat, 'jumlah_perempuan')
            + $this->sumKunjunganrealtime('wismanakomodasi', $tanggalFormat, 'jml_wisman_laki')
            + $this->sumKunjunganrealtime('wismanakomodasi', $tanggalFormat, 'jml_wisman_perempuan');
    
        $totalEvent = $this->sumKunjunganrealtime('wisnu_event', $tanggalFormat, 'jumlah_laki_laki')
            + $this->sumKunjunganrealtime('wisnu_event', $tanggalFormat, 'jumlah_perempuan')
            + $this->sumKunjunganrealtime('wisman_event', $tanggalFormat, 'jml_wisman_laki')
            + $this->sumKunjunganrealtime('wisman_event', $tanggalFormat, 'jml_wisman_perempuan');
    
        // Menyimpan data kunjungan untuk tanggal ini
        $kunjungan[$tanggalFormat] = [
            'totalkunjunganWisata' => $totalWisata ?: 0,
            'totalkunjunganKuliner' => $totalKuliner ?: 0,
            'totalkunjunganAkomodasi' => $totalAkomodasi ?: 0,
            'totalkunjunganEvent' => $totalEvent ?: 0,
    
            'jumlah_laki_laki' => $jumlahLakiLaki ?: 0,
            'jumlah_perempuan' => $jumlahPerempuan ?: 0,
            'kelompok' => $wisnuByKelompok,
            'jml_wisman_laki' => $jmlWismanLaki ?: 0,
            'jml_wisman_perempuan' => $jmlWismanPerempuan ?: 0,
            'wisman_by_negara' => $wismanByNegara,
        ];
    }
    
    // Mengurutkan data berdasarkan tanggal
    $kunjungan = collect($kunjungan)->sortBy(fn ($item, $key) => $key);
    
    // Mengambil nilai-nilai yang diperlukan untuk grafik atau tampilan
    $dates = $kunjungan->keys()->toArray();
    $jumlahLakiLaki = $kunjungan->pluck('jumlah_laki_laki')->toArray();
    $jumlahPerempuan = $kunjungan->pluck('jumlah_perempuan')->toArray();
    $jmlWismanLaki = $kunjungan->pluck('jml_wisman_laki')->toArray();
    $jmlWismanPerempuan = $kunjungan->pluck('jml_wisman_perempuan')->toArray();
    
    $totalWisata = $kunjungan->pluck('totalkunjunganWisata')->toArray();
    $totalKuliner = $kunjungan->pluck('totalkunjunganKuliner')->toArray();
    $totalAkomodasi = $kunjungan->pluck('totalkunjunganAkomodasi')->toArray();
    $totalEvent = $kunjungan->pluck('totalkunjunganEvent')->toArray();
    
    // Ambil data tambahan untuk kelompok dan negara
    $kelompok = KelompokKunjungan::all();
    $wismannegara = WismanNegara::all();
    
    // Kembalikan data ke tampilan
    return view('admin.datakunjungan.realtime', compact(
        'kunjungan', 'kelompok', 'wismannegara', 'hash', 'filter', 'startDate', 'endDate',
        'totalEvent', 'totalAkomodasi', 'totalWisata', 'totalKuliner',
        'dates', 'jumlahLakiLaki', 'jumlahPerempuan', 'jmlWismanLaki', 'jmlWismanPerempuan',
        'wisata', 'akomodasi', 'kuliner', 'event'
    ));
}

private function sumKunjunganrealtime($table, $tanggal, $column)
{
    return DB::table($table)
        ->select(DB::raw("SUM($column) as total"))
        ->whereDate('tanggal_kunjungan', $tanggal)
        ->first()
        ->total ?? 0;  // Mengembalikan total 0 jika tidak ada data
}



}