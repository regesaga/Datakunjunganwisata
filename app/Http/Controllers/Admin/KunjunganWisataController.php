<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\WisnuWisata;
use App\Models\KelompokKunjungan;
use App\Models\WismanWisata;
use App\Models\WismanNegara;
use App\Models\Wisata;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class KunjunganWisataController extends Controller
{
    public function indexkunjunganwisata()
    {
        $hash = new Hashids();
        // Fetch data from the database
        $wisnuKunjungan = WisnuWisata::select('tanggal_kunjungan', 'jumlah_laki_laki', 'jumlah_perempuan', 'kelompok_kunjungan_id')
            ->get()
            ->groupBy('tanggal_kunjungan');
    
        $wismanKunjungan = WismanWisata::select('tanggal_kunjungan', 'jml_wisman_laki', 'jml_wisman_perempuan', 'wismannegara_id')
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
    
        return view('account.wisata.kunjunganwisata.index', compact('kunjungan', 'kelompok', 'wismannegara', 'hash'));
    }
    

// Menampilkan form input kunjungan
public function createwisnu()
{
    $company_id = auth()->user()->company->id;
    $kelompok = KelompokKunjungan::all();
    $wisata = Wisata::where('company_id', $company_id)->first();
    $wismannegara = WismanNegara::all();
    return view('account.wisata.kunjunganwisata.create', compact('wisata','kelompok','wismannegara'))->with([
        'wisata' => $wisata,
        'kelompok' => $kelompok,
        'wismannegara' => $wismannegara

    ]);
}

// Menyimpan data kunjungan
public function storewisnu(Request $request)
{
    // Validasi input
    $request->validate([
        'wisata_id' => 'required', // Pastikan wisata_id valid
        'tanggal_kunjungan' => 'required|date', // Pastikan wisata_id valid
        'jumlah_laki_laki' => 'required|array', // Pastikan ini adalah array
        'jumlah_perempuan' => 'required|array', // Pastikan ini adalah array
        'jumlah_laki_laki.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer
        'jumlah_perempuan.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer

        'wismannegara_id' => 'required|array', // Pastikan ini adalah array
        'jml_wisman_laki' => 'required|array', // Pastikan ini adalah array
        'jml_wisman_perempuan' => 'required|array', // Pastikan ini adalah array
        'jml_wisman_laki.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer
        'jml_wisman_perempuan.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer
    ]);

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

        // Loop untuk data WISMAN (Wisatawan Mancanegara)
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
public function editwisnu($tanggal_kunjungan)
{
    $company_id = auth()->user()->company->id;
    $wisata = Wisata::where('company_id', $company_id)->first();
    // Retrieve data from both tables based on the date
    $wisnuData = WisnuWisata::where('tanggal_kunjungan', $tanggal_kunjungan)
                            ->with('kelompokkunjungan')
                            ->get();
    $wismanData = WismanWisata::where('tanggal_kunjungan', $tanggal_kunjungan)
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
    $hash = new Hashids();

    // Pass data to the view
    return view('account.wisata.kunjunganwisata.edit', compact('wisnuData', 'aggregatedWismanData','aggregatedWisnuData','tanggal_kunjungan','wismanData', 'wisata', 'kelompok', 'wismannegara', 'hash'));
}

public function updatewisnu(Request $request, $tanggal_kunjungan)
{
    // Validasi input
    $request->validate([
        'wisata_id' => 'required|exists:wisatas,id', // Pastikan wisata_id valid
        'tanggal_kunjungan' => 'required|date', // Pastikan tanggal kunjungan valid
        'jumlah_laki_laki' => 'required|array', // Pastikan ini adalah array
        'jumlah_perempuan' => 'required|array', // Pastikan ini adalah array
        'jumlah_laki_laki.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer
        'jumlah_perempuan.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer

        'wismannegara_id' => 'required|array', // Pastikan ini adalah array
        'jml_wisman_laki' => 'required|array', // Pastikan ini adalah array
        'jml_wisman_perempuan' => 'required|array', // Pastikan ini adalah array
        'jml_wisman_laki.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer
        'jml_wisman_perempuan.*' => 'required|integer|min:0', // Setiap nilai dalam array harus integer
    ]);

    // Mulai transaksi
    DB::beginTransaction();
    Log::info('Starting updatewisnu method', ['tanggal_kunjungan' => $tanggal_kunjungan]);

    try {
        // Hapus data sebelumnya berdasarkan wisata_id dan tanggal kunjungan
        $deletedWisnu = WisnuWisata::where('wisata_id', $request->wisata_id)
                                     ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                     ->delete();

        $deletedWisman = WismanWisata::where('wisata_id', $request->wisata_id)
                                       ->where('tanggal_kunjungan', $tanggal_kunjungan)
                                       ->delete();

        // Log penghapusan data
        Log::info('Previous WISNU and WISMAN data deleted', [
            'deleted_wisnu_count' => $deletedWisnu,
            'deleted_wisman_count' => $deletedWisman,
        ]);

        // Loop untuk data WISNU (Wisatawan Nusantara)
        foreach ($request->jumlah_laki_laki as $kelompok => $jumlah_laki) {
            $jumlah_perempuan = $request->jumlah_perempuan[$kelompok];

            // Buat entri baru untuk WISNU
            WisnuWisata::create([
                'wisata_id' => $request->wisata_id,
                'kelompok_kunjungan_id' => $kelompok,
                'tanggal_kunjungan' => $request->tanggal_kunjungan, // gunakan tanggal baru
                'jumlah_laki_laki' => $jumlah_laki,
                'jumlah_perempuan' => $jumlah_perempuan,
                'updated_at' => now(),
            ]);
        }

        // Loop untuk data WISMAN (Wisatawan Mancanegara)
        foreach ($request->wismannegara_id as $index => $negara) {
            $jumlah_wisman_laki = $request->jml_wisman_laki[$index];
            $jumlah_wisman_perempuan = $request->jml_wisman_perempuan[$index];

            // Buat entri baru untuk WISMAN
            WismanWisata::create([
                'wisata_id' => $request->wisata_id,
                'wismannegara_id' => $negara,
                'tanggal_kunjungan' => $request->tanggal_kunjungan, // gunakan tanggal baru
                'jml_wisman_laki' => $jumlah_wisman_laki,
                'jml_wisman_perempuan' => $jumlah_wisman_perempuan,
                'updated_at' => now(),
            ]);
        }

        // Commit transaksi
        DB::commit();
        
        // Notifikasi sukses
        return redirect()->route('account.wisata.kunjunganwisata.index')->with('success', 'Data kunjungan berhasil diperbarui.');

    } catch (\Exception $e) {
        // Rollback jika terjadi error
        DB::rollBack();

        // Log error
        Log::error('Failed to save kunjungan to database.', [
            'error_message' => $e->getMessage(),
            'request_data' => $request->all(),
            'trace' => $e->getTraceAsString()
        ]);

        // Tampilkan pesan kesalahan kepada pengguna dengan detail error
        return redirect()->back()->with('error', 'Gagal menyimpan data kunjungan. Silakan coba lagi. Kesalahan: ' . $e->getMessage())
                                 ->withInput($request->all());
    }
}









}

