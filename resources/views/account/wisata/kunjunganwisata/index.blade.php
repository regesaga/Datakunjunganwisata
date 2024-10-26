@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<div class="container">
    <h2>Laporan Kunjungan Wisatawan Nusantara</h2>
    <a class="btn btn-success" href="{{ route("account.wisata.kunjunganwisata.createwisnu") }}">
        Tambah Data
    </a>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th rowspan="2">Tanggal</th>

                <!-- Header Kelompok (Otomatis) -->
                @foreach ($kelompok as $namaKelompok)
                    <th colspan="2">{{ $namaKelompok }}</th>
                @endforeach
            </tr>
            <tr>
                <!-- Sub-header Laki-laki dan Perempuan -->
                @foreach ($kelompok as $namaKelompok)
                    <th>L</th>
                    <th>P</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($kunjungan->groupBy('tanggal') as $tanggal => $dataTanggal)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</td>

                    <!-- Data Kunjungan per Kelompok (Otomatis) -->
                    @foreach ($kelompok as $namaKelompok)
                        <td>{{ $dataTanggal->where('kelompok', $namaKelompok)->sum('jumlah_laki_laki') }}</td>
                        <td>{{ $dataTanggal->where('kelompok', $namaKelompok)->sum('jumlah_perempuan') }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
