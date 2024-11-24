@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Tahun dan Wisata -->
        <form action="{{ route('admin.datakunjungan.semua') }}" method="GET">
            <div class="row">
                <div class="col-lg-3">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="semua" {{ request()->get('kategori') == 'semua' ? 'selected' : '' }}>SEMUA</option>
                        <option value="wisata" {{ request()->get('kategori') == 'wisata' ? 'selected' : '' }}>WISATA</option>
                        <option value="akomodasi" {{ request()->get('kategori') == 'akomodasi' ? 'selected' : '' }}>AKOMODASI</option>
                        <option value="kuliner" {{ request()->get('kategori') == 'kuliner' ? 'selected' : '' }}>KULINER</option>
                    </select>
                </div>
        
                <div class="col-lg-3">
                    <label for="tahun">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        @foreach(range(date('Y'), date('Y') - 10) as $year)
                            <option value="{{ $year }}" {{ request()->get('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-info">Filter</button>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-outline-success" id="export-to-excel">Export to Excel</button> <!-- Tombol Export -->
                <button class="btn btn-outline-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->
            </div>
            <div class="card-body">
               
                <table id="example1" class="table table-bordered table-striped">
                    
                    <thead>
                        <tr>
                            <th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                                <h2 style="text-align: center; text-transform: uppercase;">
                                    @if(request()->get('kategori') == 'semua')
                                        DATA KUNJUNGAN TAHUN {{$tahun}}
                                    @elseif(request()->get('kategori') == 'wisata')
                                        DATA KUNJUNGAN WISATA TAHUN {{$tahun}}
                                    @elseif(request()->get('kategori') == 'kuliner')
                                        DATA KUNJUNGAN KULINER TAHUN{{$tahun}}
                                    @elseif(request()->get('kategori') == 'akomodasi')
                                    DATA KUNJUNGAN AKOMODASI TAHUN{{$tahun}}
                                    @endif
                                </h2>
                                
                                
                                
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: left; text-transform: uppercase;" rowspan="2">Bulan</th>
                            <th style="text-align: center; text-transform: uppercase;" rowspan="2">Total</th>
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center; text-transform: uppercase;" colspan="2">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                                <th style="text-align: center; text-transform: uppercase;" colspan="2">{{ $negara->wismannegara_name }}</th>
                            @endforeach
                        </tr>
                        <tr >
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center; text-transform: uppercase;">L</th>
                                <th style="text-align: center; text-transform: uppercase;">P</th>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                                <th style="text-align: center; text-transform: uppercase;">L</th>
                                <th style="text-align: center; text-transform: uppercase;">P</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungan as $month => $dataBulan)
                            <tr>
                                <td>
                                    <p style="text-align: left; text-transform: uppercase;">
                                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                    </p>
                                </td>
                    
                                <td style="text-align: center; text-transform: uppercase;">
                                    {{ ($dataBulan['jumlah_laki_laki'] ?? 0) + ($dataBulan['jumlah_perempuan'] ?? 0) + ($dataBulan['jml_wisman_laki'] ?? 0) + ($dataBulan['jml_wisman_perempuan'] ?? 0) }}
                                </td>
                    
                                @foreach ($kelompok as $namaKelompok)
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ ($dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?? 0) }}
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ ($dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?? 0) }}
                                    </td>
                                @endforeach
                    
                                @foreach ($wismannegara as $negara)
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ ($dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') ?? 0) }}
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ ($dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') ?? 0) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th style="text-align: left; text-transform: uppercase;">Total Keseluruhan</th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(function($dataBulan) {
                                    return $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'];
                                }) }}
                            </th>
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                                    return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki');
                                }) }}</th>
                                <th style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                                    return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan');
                                }) }}</th>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                                <th style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                                    return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                                }) }}</th>
                                <th style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                                    return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan');
                                }) }}</th>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
