@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">

        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('admin.kunjunganwisata.index') }}">
            <div class="row">
                <div class="col-lg-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select name="categorywisata_id" class="form-control select2">
                        <option value="">Semua Tempat Wisata</option>
                        @foreach($kategoriWisata as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('categorywisata_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun" class="form-control select2">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-lg-3">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select id="bulan" name="bulan" class="form-control select2">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
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

        <!-- Tabel Data Kunjungan -->
        <div class="card mt-4">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route('admin.kunjunganwisata.createwisnu') }}">
                    Tambah Data
                </a>
            </div>
            <h3 style="text-align: center;">Rekapan Kunjungan Bulan  {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} Tahun {{ $tahun }}</h3>
            <h2 style="text-align: center;">{{ $kategoriWisata->find($categorywisata_id)->category_name ?? 'Semua Tempat Wisata' }} </h2>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="3" style="text-align: center;">Wisata</th>
                            <th rowspan="3" style="text-align: center;">Total</th>
                            <th colspan="{{ count($kelompok) * 2 }}" style="text-align: center;">Wisata Nusantara</th>
                            <th colspan="2" style="text-align: center;">Wisata Mancanegara</th>
                        </tr>
                        <tr>
                            @foreach ($kelompok as $namaKelompok)
                                <th colspan="2" style="text-align: center;">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                            @endforeach
                            <th colspan="2" style="text-align: center;">Total Wisata Mancanegara</th>
                        </tr>
                        <tr>
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center;">L</th>
                                <th style="text-align: center;">P</th>
                            @endforeach
                            <th style="text-align: center;">Laki - Laki</th>
                            <th style="text-align: center;">Perempuan</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($kunjungan as $dataTanggal)
                            <tr>
                                <td>{{ $dataTanggal['wisata']->namawisata }}</td>
                                <td>
                                    {{ $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                                </td>
                                <!-- Data berdasarkan Kelompok -->
                                @foreach ($kelompok as $namaKelompok)
                                    <td>{{ $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0 }}</td>
                                    <td>{{ $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0 }}</td>
                                @endforeach
                                <!-- Data Total Wisata Mancanegara -->
                                <td>{{ $dataTanggal['jml_wisman_laki'] ?: 0 }}</td>
                                <td>{{ $dataTanggal['jml_wisman_perempuan'] ?: 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + count($kelompok) * 2 + 2 }}">Tidak ada data tersedia untuk filter yang dipilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>
                                {{ $kunjungan->sum(fn($dataTanggal) => 
                                    $dataTanggal['jumlah_laki_laki'] + 
                                    $dataTanggal['jumlah_perempuan'] + 
                                    $dataTanggal['jml_wisman_laki'] + 
                                    $dataTanggal['jml_wisman_perempuan']
                                ) }}
                            </th>
                            @foreach ($kelompok as $namaKelompok)
                                <th>
                                    {{ $kunjungan->sum(fn($dataTanggal) => 
                                        $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0
                                    ) }}
                                </th>
                                <th>
                                    {{ $kunjungan->sum(fn($dataTanggal) => 
                                        $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0
                                    ) }}
                                </th>
                            @endforeach
                            <th>
                                {{ $kunjungan->sum(fn($dataTanggal) => $dataTanggal['jml_wisman_laki'] ?: 0) }}
                            </th>
                            <th>
                                {{ $kunjungan->sum(fn($dataTanggal) => $dataTanggal['jml_wisman_perempuan'] ?: 0) }}
                            </th>
                            
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
