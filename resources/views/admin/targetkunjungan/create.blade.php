@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Bulan dan Tahun -->
        <form method="POST" action="{{ route('admin.targetkunjungan.storetarget') }}">
            @csrf
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="" disabled selected>Pilih Tahun</option>
                    @for ($tahun = 2022; $tahun <= 2026; $tahun++)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
        
            <div class="form-group">
                <label for="bulan">Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="" disabled selected>Pilih Bulan</option>
                    @php
                        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp
                    @foreach ($namaBulan as $key => $bulan)
                        <option value="{{ $key + 1 }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="form-group">
                <label for="target_kunjungan_wisata">Target Kunjungan Wisata</label>
                <input type="number" name="target_kunjungan_wisata" id="target_kunjungan_wisata" class="form-control" required>
            </div>
        
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tahunSelect = document.getElementById('tahun');
        const bulanSelect = document.getElementById('bulan');
        const bulanTersedia = @json($bulanTersedia); // Data dari backend
        
        // Event Listener untuk tahun
        tahunSelect.addEventListener('change', function () {
            const selectedTahun = this.value;

            // Bersihkan semua opsi bulan
            for (let i = 0; i < bulanSelect.options.length; i++) {
                bulanSelect.options[i].disabled = false; // Reset semua bulan
            }

            // Cek bulan yang sudah ada di database untuk tahun yang dipilih
            if (bulanTersedia[selectedTahun]) {
                const disabledMonths = bulanTersedia[selectedTahun];
                for (let i = 0; i < bulanSelect.options.length; i++) {
                    const bulanValue = bulanSelect.options[i].value;
                    if (disabledMonths.includes(parseInt(bulanValue))) {
                        bulanSelect.options[i].disabled = true; // Nonaktifkan bulan
                    }
                }
            }
        });

        // Trigger event change awal untuk mengatur bulan berdasarkan tahun default
        tahunSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
