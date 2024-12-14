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
use App\Models\Company;
use App\Models\TargetKunjungan;
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
        $company = Company::pluck('id');
        $jumlah_userwisata = Wisata::whereIn('company_id', $company)->count();
        $jumlah_userkuliner = Kuliner::whereIn('company_id', $company)->count();
        $jumlah_userakomodasi = Akomodasi::whereIn('company_id', $company)->count();
        
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
    
        $targetKunjungan = TargetKunjungan::getTargetPerYear($year);

        $semuakunjungan = [];

        foreach ($targetKunjungan as $target) {
            $bulan = $target->bulan;

            // Total kunjungan per bulan dari berbagai tabel
            $totalKunjungan = 
                WisnuWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                WisnuWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                WismanWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_laki') +
                WismanWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                WisnuKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                WisnuKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                WismanKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                WismanKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                WisnuAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                WisnuAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                WismanAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                WismanAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                WisnuEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_laki_laki') +
                WisnuEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jumlah_perempuan') +
                WismanEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan') +
                WismanEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $year)->sum('jml_wisman_perempuan');

            // Menyimpan data ke dalam array
            $semuakunjungan[] = [
                'bulan' => $bulan,
                'target' => $target->target_kunjungan_wisata,
                'realisasi' => $totalKunjungan,
                'selisih' => $totalKunjungan - $target->target_kunjungan_wisata,
            ];
        }

       
        return response()->json([
            // 'negaraData' => $wismannegara,
            // 'kunjungan' => $kunjungan,
            // 'kelompok' => $kelompok,
            // 'totalKeseluruhan' => $totalKeseluruhan,
            // 'bulan' => $bulan,
           
            'data' => [
                'operatorwisata' => $jumlah_userwisata,
                'operatorkuliner' => $jumlah_userkuliner,
                'operatorakomodasi' => $jumlah_userakomodasi,
                'totalKunjungan' => $totalKunjungan,
                'totalKeseluruhan' => $totalKeseluruhan,
                'target' => $semuakunjungan
               
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


    public function getKunjunganBytgl()
    {
        // Ambil semua data berdasarkan tanggal dan kategori
        $data = collect();

        // Data untuk Wisnu (domestik)
        $wisnuKunjungan = DB::table(function ($query) {
            $query->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                ->from('wisnuwisata')
                ->unionAll(
                    DB::table('wisnuakomodasi')
                        ->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                )
                ->unionAll(
                    DB::table('wisnu_event')
                        ->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                )
                ->unionAll(
                    DB::table('wisnukuliner')
                        ->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, jumlah_laki_laki, jumlah_perempuan')
                );
        })->get();

        // Data untuk Wisman (internasional)
        $wismanKunjungan = DB::table(function ($query) {
            $query->selectRaw('tanggal_kunjungan, wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                ->from('wismanwisata')
                ->unionAll(
                    DB::table('wismanakomodasi')
                        ->selectRaw('tanggal_kunjungan, wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                )
                ->unionAll(
                    DB::table('wisman_event')
                        ->selectRaw('tanggal_kunjungan, wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                )
                ->unionAll(
                    DB::table('wismankuliner')
                        ->selectRaw('tanggal_kunjungan, wismannegara_id, jml_wisman_laki, jml_wisman_perempuan')
                );
        })->get();

        // Kelompok Kunjungan
        $kelompok = KelompokKunjungan::select('id', 'kelompokkunjungan_name')->get();
        // Wisman Negara
        $wismannegara = WismanNegara::select('id', 'wismannegara_name')->get();

        // Mengolah data Wisnu dan Wisman untuk setiap tanggal
        foreach ($wisnuKunjungan->groupBy('tanggal_kunjungan') as $tanggal => $wisnuItems) {
            $tanggalData = [
                'tanggal_kunjungan' => $tanggal,
                'kelompok_kunjungan' => [],
                'wisman_by_negara' => [],
                'total_kunjungan' => 0
            ];

            // Proses Kelompok Kunjungan untuk Wisnu
            foreach ($wisnuItems->groupBy('kelompok_kunjungan_id') as $kelompokId => $wisnuGroup) {
                $kelompokData = $kelompok->firstWhere('id', $kelompokId);
                $jumlahLakiLaki = $wisnuGroup->sum('jumlah_laki_laki');
                $jumlahPerempuan = $wisnuGroup->sum('jumlah_perempuan');

                $tanggalData['kelompok_kunjungan'][] = [
                    'kelompok_kunjungan_id' => $kelompokId,
                    'nama_kelompok' => $kelompokData ? $kelompokData->kelompokkunjungan_name : 'Tidak Ditemukan',
                    'jumlah_laki_laki' => $jumlahLakiLaki,
                    'jumlah_perempuan' => $jumlahPerempuan
                ];

                $tanggalData['total_kunjungan'] += ($jumlahLakiLaki + $jumlahPerempuan);
            }

            // Menambahkan data Wisman berdasarkan negara
            foreach ($wismanKunjungan->where('tanggal_kunjungan', $tanggal)->groupBy('wismannegara_id') as $negaraId => $wismanGroup) {
                $negaraData = $wismannegara->firstWhere('id', $negaraId);
                $jumlahLakiLaki = $wismanGroup->sum('jml_wisman_laki');
                $jumlahPerempuan = $wismanGroup->sum('jml_wisman_perempuan');

                $tanggalData['wisman_by_negara'][] = [
                    'wismannegara_id' => $negaraId,
                    'nama_negara' => $negaraData ? $negaraData->wismannegara_name : 'Tidak Ditemukan',
                    'jml_wisman_laki' => $jumlahLakiLaki,
                    'jml_wisman_perempuan' => $jumlahPerempuan
                ];

                $tanggalData['total_kunjungan'] += ($jumlahLakiLaki + $jumlahPerempuan);
            }

            $data->push($tanggalData);
        }

        return response()->json([
            'messages' => 'Data Kunjungan Semua',
            'success' => true,
            'data' => $data
        ]);
    }

    // public function getKunjunganBytglpisah()
    // {
    //     // Ambil semua data berdasarkan tanggal dan kategori
    //     $data = collect();
    
    //     // Data untuk Wisnu (domestik)
    //     $wisnuKunjungan = DB::table(function ($query) {
    //         $query->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, kelompok_kunjungan_name, jumlah_laki_laki, jumlah_perempuan')
    //             ->from('wisnuwisata')
    //             ->unionAll(
    //                 DB::table('wisnuakomodasi')
    //                     ->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, kelompok_kunjungan_name, jumlah_laki_laki, jumlah_perempuan')
    //             )
    //             ->unionAll(
    //                 DB::table('wisnu_event')
    //                     ->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, kelompok_kunjungan_name, jumlah_laki_laki, jumlah_perempuan')
    //             )
    //             ->unionAll(
    //                 DB::table('wisnukuliner')
    //                     ->selectRaw('tanggal_kunjungan, kelompok_kunjungan_id, kelompok_kunjungan_name, jumlah_laki_laki, jumlah_perempuan')
    //             );
    //     })->get();
    
    //     // Data untuk Wisman (internasional)
    //     $wismanKunjungan = DB::table(function ($query) {
    //         $query->selectRaw('tanggal_kunjungan, wismannegara_id, wismannegara_name, jml_wisman_laki, jml_wisman_perempuan')
    //             ->from('wismanwisata')
    //             ->unionAll(
    //                 DB::table('wismanakomodasi')
    //                     ->selectRaw('tanggal_kunjungan, wismannegara_id, wismannegara_name, jml_wisman_laki, jml_wisman_perempuan')
    //             )
    //             ->unionAll(
    //                 DB::table('wisman_event')
    //                     ->selectRaw('tanggal_kunjungan, wismannegara_id, wismannegara_name, jml_wisman_laki, jml_wisman_perempuan')
    //             )
    //             ->unionAll(
    //                 DB::table('wismankuliner')
    //                     ->selectRaw('tanggal_kunjungan, wismannegara_id, wismannegara_name, jml_wisman_laki, jml_wisman_perempuan')
    //             );
    //     })->get();
    
    //     // Kelompok Kunjungan
    //     $kelompok = KelompokKunjungan::select('id', 'kelompokkunjungan_name')->get();
    //     // Wisman Negara
    //     $wismannegara = WismanNegara::select('id', 'wismannegara_name')->get();
    
    //     // Daftar kategori kunjungan yang ingin diproses
    //     $kategoriKunjungan = [
    //         'akomodasi' => ['wisnuakomodasi'], 
    //         'kuliner' => ['wisnukuliner'],
    //         'wisata' => ['wisnuwisata'],
    //         'event' => ['wisnu_event']
    //     ];
    
    //     // Mengolah data Wisnu dan Wisman untuk setiap tanggal
    //     foreach ($wisnuKunjungan->groupBy('tanggal_kunjungan') as $tanggal => $wisnuItems) {
    //         // Data berdasarkan jenis kunjungan
    //         $jenisKunjunganData = [];
    
    //         // Loop melalui setiap kategori kunjungan
    //         foreach ($kategoriKunjungan as $jenis => $kategoriTables) {
    //             // Ambil data berdasarkan kategori
    //             $items = $wisnuItems->filter(function ($item) use ($kategoriTables) {
    //                 return in_array($item->kelompok_kunjungan_name, $kategoriTables);
    //             });
    
    //             // Jika ada data untuk kategori ini
    //             if ($items->isNotEmpty()) {
    //                 // Menghasilkan data kunjungan berdasarkan jenis
    //                 $jenisKunjunganData[] = $this->generateKunjunganData($jenis, $items, $tanggal, $kelompok, $wismanKunjungan, $wismannegara);
    //             }
    //         }
    
    //         // Menambahkan data ke koleksi
    //         foreach ($jenisKunjunganData as $jenisData) {
    //             $data->push($jenisData);
    //         }
    //     }
    
    //     return response()->json([
    //         'messages' => 'Data Kunjungan Semua',
    //         'success' => true,
    //         'data' => $data
    //     ]);
    // }
    
    // private function generateKunjunganData($jenis, $items, $tanggal, $kelompok, $wismanKunjungan, $wismannegara)
    // {
    //     $jenisKunjunganData = [
    //         'tanggal_kunjungan' => $tanggal,
    //         'jeniskunjungan' => $jenis,
    //         'nama_' . $jenis => '', // Bisa diganti dengan data sesuai kebutuhan
    //         'kelompok_kunjungan' => [],
    //         'wisman_by_negara' => [],
    //         'total_kunjungan' => 0
    //     ];
    
    //     // Proses Kelompok Kunjungan
    //     foreach ($items->groupBy('kelompok_kunjungan_name') as $kelompokName => $group) {
    //         $kelompokData = $kelompok->firstWhere('kelompokkunjungan_name', $kelompokName);
    //         $jumlahLakiLaki = $group->sum('jumlah_laki_laki');
    //         $jumlahPerempuan = $group->sum('jumlah_perempuan');
    
    //         $jenisKunjunganData['kelompok_kunjungan'][] = [
    //             'kelompok_kunjungan_name' => $kelompokName,
    //             'nama_kelompok' => $kelompokData ? $kelompokData->kelompokkunjungan_name : 'Tidak Ditemukan',
    //             'jumlah_laki_laki' => $jumlahLakiLaki,
    //             'jumlah_perempuan' => $jumlahPerempuan
    //         ];
    
    //         $jenisKunjunganData['total_kunjungan'] += ($jumlahLakiLaki + $jumlahPerempuan);
    //     }
    
    //     // Menambahkan data Wisman berdasarkan negara
    //     foreach ($wismanKunjungan->where('tanggal_kunjungan', $tanggal)->groupBy('wismannegara_name') as $negaraName => $wismanGroup) {
    //         $negaraData = $wismannegara->firstWhere('wismannegara_name', $negaraName);
    //         $jumlahLakiLaki = $wismanGroup->sum('jml_wisman_laki');
    //         $jumlahPerempuan = $wismanGroup->sum('jml_wisman_perempuan');
    
    //         $jenisKunjunganData['wisman_by_negara'][] = [
    //             'wismannegara_name' => $negaraName,
    //             'nama_negara' => $negaraData ? $negaraData->wismannegara_name : 'Tidak Ditemukan',
    //             'jml_wisman_laki' => $jumlahLakiLaki,
    //             'jml_wisman_perempuan' => $jumlahPerempuan
    //         ];
    
    //         $jenisKunjunganData['total_kunjungan'] += ($jumlahLakiLaki + $jumlahPerempuan);
    //     }
    
    //     return $jenisKunjunganData;
    // }
    



}