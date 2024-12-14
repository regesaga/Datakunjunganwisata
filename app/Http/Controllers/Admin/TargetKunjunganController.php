<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\TargetKunjungan;
use App\Models\WisnuWisata;
use App\Models\WismanWisata;
use App\Models\WisnuKuliner;
use App\Models\WismanKuliner;
use App\Models\WisnuAkomodasi;
use App\Models\WismanAkomodasi;

use App\Models\WisnuEvent;
use App\Models\WismanEvent;
use Illuminate\Http\Request;
use Hashids\Hashids;
class TargetKunjunganController extends Controller
{
    // Menampilkan form untuk menambah target
    public function perbandingan(Request $request)
    {
        // Ambil data target kunjungan per bulan untuk tahun yang diminta
        $tahun = $request->input('tahun', date('Y'));

        $targetKunjungan = TargetKunjungan::getTargetPerYear($tahun);

        // Ambil data kunjungan dari berbagai tabel
        $kunjungan = [];

        foreach ($targetKunjungan as $target) {
            $bulan = $target->bulan;

            // Total kunjungan per bulan dari tabel WisnuWisata, WismanWisata, WisnuKuliner, WismanKuliner, WisnuAkomodasi, WismanAkomodasi
            $totalKunjungan = WisnuWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_laki_laki') +
                              WisnuWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_perempuan') +
                              WismanWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_laki') +
                              WismanWisata::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_perempuan') +
                              WisnuKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_laki_laki') +
                              WisnuKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_perempuan') +
                              WismanKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_perempuan') +
                              WismanKuliner::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_perempuan') +
                              WisnuAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_laki_laki') +
                              WisnuAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_perempuan') +
                              WismanAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_perempuan') +
                              WismanAkomodasi::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_perempuan')+

                              WisnuEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_laki_laki') +
                              WisnuEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jumlah_perempuan') +
                              WismanEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_perempuan') +
                              WismanEvent::whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun)->sum('jml_wisman_perempuan');


            // Menambahkan data perbandingan target dan realisasi kunjungan
            $kunjungan[] = [
                'bulan' => $bulan,
                'target' => $target->target_kunjungan_wisata,
                'realisasi' => $totalKunjungan,
                'selisih' => $totalKunjungan - $target->target_kunjungan_wisata
            ];
        }

        return view('admin.targetkunjungan.perbandingan', compact('kunjungan', 'tahun'));
    }

    public function index(Request $request)
    {
        $hash = new Hashids();
        // Ambil data tahun yang dipilih (default ke tahun saat ini jika tidak ada)
        $tahun = $request->input('tahun', date('Y'));

        // Ambil data target kunjungan berdasarkan tahun yang dipilih
        $targetKunjungan = TargetKunjungan::where('tahun', $tahun)
            ->orderBy('bulan', 'asc')  // Urutkan berdasarkan bulan
            ->get();

        // Ambil daftar tahun yang ada di database untuk filter
        $tahunList = TargetKunjungan::select('tahun')->distinct()->get();

        return view('admin.targetkunjungan.index', compact('targetKunjungan', 'tahun', 'tahunList','hash'));
    }
    public function create()
{
    $tahunList = TargetKunjungan::select('tahun')->distinct()->get(); // Data tahun tersedia
    $targetKunjungan = TargetKunjungan::all(); // Ambil semua target kunjungan

    // Format data untuk JavaScript
    $bulanTersedia = [];
    foreach ($targetKunjungan as $target) {
        $bulanTersedia[$target->tahun][] = $target->bulan;
    }

    return view('admin.targetkunjungan.create', compact('tahunList', 'bulanTersedia'));
}

    public function getBulanTersedia(Request $request)
    {
        $request->validate(['tahun' => 'required|integer']);

        $bulanTersedia = TargetKunjungan::where('tahun', $request->tahun)
            ->pluck('bulan')
            ->toArray();

        return response()->json($bulanTersedia);
    }


    // Method storetarget tetap seperti sebelumnya
    public function storetarget(Request $request)
    {
        // Validasi dan penyimpanan data
        $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|between:1,12',
            'target_kunjungan_wisata' => 'required|integer|min:0',
        ]);

        // Cek apakah sudah ada data untuk bulan dan tahun yang dipilih
        $existingTarget = TargetKunjungan::where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)
            ->first();

        if ($existingTarget) {
            // Jika sudah ada, jumlahkan data target_kunjungan_wisata
            $existingTarget->target_kunjungan_wisata += $request->target_kunjungan_wisata;
            $existingTarget->save();
            return redirect()->route('admin.targetkunjungan.index')
                             ->with('success', 'Target kunjungan berhasil diperbarui');
        }

        // Jika belum ada, buat data baru
        TargetKunjungan::create([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'target_kunjungan_wisata' => $request->target_kunjungan_wisata,
        ]);

        return redirect()->route('admin.targetkunjungan.index')->with('success', 'Target kunjungan berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $hash = new Hashids();
        // Decode ID jika menggunakan hash
        $decodedId = $hash->decodeHex($id);
    
        // Cari data berdasarkan ID
        $targetKunjungan = TargetKunjungan::find($decodedId);
    
        // Periksa apakah data ditemukan
        if (!$targetKunjungan) {
            abort(404, 'Data tidak ditemukan');
        }
    
        // Kirim data ke view
        return view('admin.targetkunjungan.edit', compact('targetKunjungan','hash'));
    }

    public function update(Request $request, $id)
    {
        $hash=new Hashids();

        // Validasi input
        $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|between:1,12',
            'target_kunjungan_wisata' => 'required|integer|min:0',
        ]);
    
        // Cari data berdasarkan ID
        $decodedId = $hash->decodeHex($id);
        $targetKunjungan = TargetKunjungan::find($decodedId);
        $targetKunjungan->update($request->all());
    
        // Pastikan data ditemukan
        if (!$targetKunjungan) {
            return redirect()->route('admin.targetkunjungan.index')->with('error', 'Data tidak ditemukan');
        }
    
        // Perbarui nilai
    
        return redirect()->route('admin.targetkunjungan.index')->with('success', 'Target kunjungan berhasil diperbarui');
    }
    

}
