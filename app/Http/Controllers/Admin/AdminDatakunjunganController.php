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

        // Gabungkan data kunjungan
        $wisnuKunjungan = DB::table('wisnuwisata')
            ->select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->union(
                DB::table('wisnuakomodasi')
                    ->select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            )
            ->union(
                DB::table('wisnukuliner')
                    ->select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            )
            ->get()
            ->groupBy('kelompok_kunjungan_id');

        $wismanKunjungan = DB::table('wismanwisata')
            ->select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->union(
                DB::table('wismanakomodasi')
                    ->select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            )
            ->union(
                DB::table('wismankuliner')
                    ->select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            )
            ->get()
            ->groupBy('wismannegara_id');

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



      // Persiapkan data untuk grafik bar
$negaraData = [];
foreach ($wismannegara as $negara) {
    $negaraData[] = [
        'name' => $negara->wismannegara_name,
        'value' => collect($kunjungan)->sum(function($dataBulan) use ($negara) {
            // Correctly access 'wisman_by_negara' as an object
            $wismanNegaraData = isset($dataBulan->wisman_by_negara) ? $dataBulan->wisman_by_negara : collect();

            // Sum 'jml_wisman_laki' and 'jml_wisman_perempuan' values
            return $wismanNegaraData->get($negara->id, collect())->sum(function($item) {
                return ($item->jml_wisman_laki ?? 0) + ($item->jml_wisman_perempuan ?? 0);
            });
        })
    ];
}






    return view('admin.datakunjungan.index', compact(
        'kunjungan', 'kelompok','kelompokData','wismannegara', 'wisata', 'hash', 'year', 'totalKeseluruhan','bulan', 'totalKunjungan','totalKunjunganLaki','totalKunjunganPerempuan','totalWisataAll','totalKulinerAll','totalAkomodasiAll', 'negaraData'
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

}

