<?php

namespace App\Http\Controllers\Api\DataKunjungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evencalender;
use App\Models\WisnuAkomodasi;
use App\Models\WisnuEvent;
use App\Models\KelompokKunjungan;
use App\Models\WismanAkomodasi;
use App\Models\WismanEvent;
use App\Models\WismanNegara;
use App\Models\Akomodasi;
use App\Models\WisnuWisata;
use App\Models\WismanWisata;
use App\Models\Wisata;
use App\Models\WisnuKuliner;
use App\Models\WismanKuliner;
use App\Models\Kuliner;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;

class KunjunganAdminController extends Controller
{
    public function dashboardadmin(Request $request)
    {

        $company_id = auth()->user()->company->id;
        $hash = new Hashids();
        $wisata = Wisata::all(); // Mendapatkan wisata terkait
        $kuliner = Kuliner::all(); // Mendapatkan kuliner terkait
        $akomodasi = Akomodasi::all(); // Mendapatkan akomodasi terkait
        $events = Evencalender::all();
        
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
              ->groupBy('kelompok_kunjungan_id');
    
            $wismanKunjungan = DB::table(function ($query) use ($startDate, $endDate) {
                $query->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                    ->from('wismanwisata')
                    ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    ->unionAll(
                        DB::table('wismanakomodasi')
                            ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    )
                    ->unionAll(
                        DB::table('wisman_event')
                            ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    )
                    ->unionAll(
                        DB::table('wismankuliner')
                            ->selectRaw('wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                    );
            })->get()
              ->groupBy('wismannegara_id');
    
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
    
        foreach ($kunjungan as $month => $dataBulan) {
            $bulan[] = \Carbon\Carbon::createFromFormat('!m', $month)->format('F');  // Nama bulan
            $totalKunjungan[] = $dataBulan['total_laki_laki'] + $dataBulan['total_perempuan'] + 
                                $dataBulan['total_wisman_laki'] + $dataBulan['total_wisman_perempuan'];  // Total kunjungan
        }
    
        return response()->json([
            // 'negaraData' => $wismannegara,
            // 'kunjungan' => $kunjungan,
            // 'kelompok' => $kelompok,
            // 'totalKeseluruhan' => $totalKeseluruhan,
            // 'bulan' => $bulan,
            'data' => [
                'totalKunjungan' => $totalKunjungan,
                'totalKeseluruhan' => $totalKeseluruhan,
            ]
        ]);
    }
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