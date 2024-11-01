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
use Hashids\Hashids;

class KunjunganWisataController extends Controller
{
    public function indexkunjunganwisata()
    {
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
    
        // Get kelompok and wisman negara
        $kelompok = KelompokKunjungan::all();
        $wismannegara = WismanNegara::all();
    
        return view('account.wisata.kunjunganwisata.index', compact('kunjungan', 'kelompok', 'wismannegara'));
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





public function createkunjunganwisata()
{
    $company_id = auth()->user()->company->id;
    $wisata = Wisata::where('company_id', $company_id)->first();
    return view('account.wisata.kunjunganwisata.create', compact('wisata'));
}

/**
 * Menyimpan data kunjunganwisata baru.
 */
public function storekunjunganwisata(Request $request)
{
    // Memulai transaksi database
    DB::beginTransaction();

    try {
        // Mengambil ID wisata dari pengguna yang terautentikasi
        $wisataId = Auth::user()->company->wisata->id;

        // Validasi data dari request
        $validatedData = $request->validate([
            'wisata_id' => 'required|exists:wisata,id', // Pastikan wisata_id valid
            'tanggal_kunjunganwisata' => 'required|date',
            'kunjungan_umum_laki' => 'required|integer|min:0',
            'kunjungan_umum_perempuan' => 'required|integer|min:0',
            'kunjungan_pelajar_laki' => 'required|integer|min:0',
            'kunjungan_pelajar_perempuan' => 'required|integer|min:0',
            'kunjungan_instansi_laki' => 'required|integer|min:0',
            'kunjungan_instansi_perempuan' => 'required|integer|min:0',
            'jml_kunjungan_perempuan' => 'required|integer|min:0',
            'jml_kunjungan_laki' => 'required|integer|min:0',
            'total_kunjungan' => 'required|integer|min:0',
            'jml_wisman_laki' => 'required|integer|min:0',
            'jml_wisman_perempuan' => 'required|integer|min:0',
            'total_wisman' => 'required|integer|min:0',
            'wisman_negara' => 'array',
            'wisman_laki' => 'array',
            'wisman_perempuan' => 'array',
        ]);

        // Menyimpan data kunjungan wisata
        KunjunganWisata::create(array_merge($validatedData, ['wisata_id' => $wisataId]));

        // Commit transaksi jika berhasil
        DB::commit();

        return redirect()->route('account.wisata.kunjunganwisata.index')
                         ->with('success', 'Data kunjungan wisata berhasil ditambahkan.');

    } catch (\Throwable $th) {
        // Rollback transaksi database jika terjadi kesalahan
        DB::rollback();
        Log::error('Gagal menyimpan data ke database: ' . $th->getMessage(), [
            'error' => $th->getMessage(),
            'request_data' => $request->all(),
        ]);

        return redirect()->route('account.wisata.kunjunganwisata.createkunjunganwisata')
                         ->with('error', 'Terjadi kesalahan saat menyimpan kunjungan wisata. Silakan coba lagi nanti.');
    }
}
/**
 * Menampilkan halaman edit kunjunganwisata.
 */



public function editkunjunganwisata($kunjunganwisata)
{
    $hash=new Hashids();
    
    $kunjunganwisata = KunjunganWisata::find($hash->decodeHex($kunjunganwisata));
    $wisatas = Wisata::all(); // Mengambil data wisata untuk ditampilkan di form edit
    return view('kunjunganwisata.edit', compact('kunjunganwisata', 'wisatas'))->with([
        'kunjunganwisata' => $kunjunganwisata,
        'hash' => $hash
    ]);
}

/**
 * Mengupdate data kunjunganwisata.
 */
public function updatekunjunganwisata(Request $request, $id)
{
    $request->validate([
        'wisata_id' => 'required|exists:wisatas,id',
        'tanggal_kunjunganwisata' => 'required|date',
        'kunjungan_umum_laki' => 'required|integer',
        'kunjungan_umum_perempuan' => 'required|integer',
        'kunjungan_pelajar_laki' => 'required|integer',
        'kunjungan_pelajar_perempuan' => 'required|integer',
        'kunjungan_instansi_laki' => 'required|integer',
        'kunjungan_instansi_perempuan' => 'required|integer',
        'wisman_negara' => 'nullable|string',
        'wisman_laki' => 'required|integer',
        'wisman_perempuan' => 'required|integer',
    ]);

    $kunjunganwisata = KunjunganWisata::findOrFail($id);
    $kunjunganwisata->update($request->all());

    return redirect()->route('kunjunganwisata.index')->with('success', 'Data kunjunganwisata berhasil diupdate.');
}

/**
 * Menghapus data kunjunganwisata.
 */
public function destroykunjunganwisata($id)
{
    $kunjunganwisata = KunjunganWisata::findOrFail($id);
    $kunjunganwisata->delete();

    return redirect()->route('kunjunganwisata.index')->with('success', 'Data kunjunganwisata berhasil dihapus.');
}

}
