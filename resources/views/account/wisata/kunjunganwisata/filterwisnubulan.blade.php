@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h2>Laporan Kunjungan Wisatawan Nusantara</h2>

        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('account.wisata.kunjunganwisata.filterwisnubulan') }}">
            <div class="row">
                <div class="col-lg-4">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun"  class="form-control select2" style="width: 100%;">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select id="bulan" name="bulan"  class="form-control select2" style="width: 100%;">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info">Terapkan Filter</button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("account.wisata.kunjunganwisata.createwisnu") }}">
                    Tambah Data
                </a>
            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">Total</th>
                        <th rowspan="2">Aksi</th>
                        @foreach ($kelompok as $namaKelompok)
                            <th colspan="2">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                        @endforeach
                        
                    </tr>
                    <tr>
                        @foreach ($kelompok as $namaKelompok)
                            <th>L</th>
                            <th>P</th>
                        @endforeach
                      
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungan as $tanggal => $dataTanggal)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</td>
                            <td>
                                {{ $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] }}
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('account.wisata.kunjunganwisata.edit', ['wisata_id' => $hash->encode($wisata->id),'tanggal_kunjungan' => $tanggal]) }}">
                                    <i class="fas fa-pencil-alt"></i> Ubah
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>

                            @foreach ($kelompok as $namaKelompok)
                                <td>{{ $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_laki_laki') }}</td>
                                <td>{{ $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_perempuan') }}</td>
                            @endforeach

                          
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>Total Keseluruhan</th>
                        <th>
                            {{ $kunjungan->sum(function($dataTanggal) {
                                return $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'];
                            }) }}
                        </th>
                        <th></th>

                        @foreach ($kelompok as $namaKelompok)
                            <th>{{ $kunjungan->sum(function($dataTanggal) use ($namaKelompok) {
                                return $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_laki_laki');
                            }) }}</th>
                            <th>{{ $kunjungan->sum(function($dataTanggal) use ($namaKelompok) {
                                return $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_perempuan');
                            }) }}</th>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>
@endsection
