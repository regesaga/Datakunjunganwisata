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



}

