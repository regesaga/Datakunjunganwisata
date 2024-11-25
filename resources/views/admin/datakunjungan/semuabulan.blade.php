@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Tahun dan Wisata -->
        <form action="{{ route('admin.datakunjungan.semuabulan') }}" method="GET">
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
                <div class="col-lg-3">
                    <label style="text-align: center; text-transform: uppercase;" for="bulan" class="form-label">Bulan</label>
                    <select id="bulan" name="bulan" class="form-control select2">
                        @foreach(range(1, 12) as $m)
                        <option style="text-align: center; text-transform: uppercase;" value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ $bulanIndo[$m] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-info">Filter</button>
                </div>
            </div>
        </form>
        
        <div class="card">
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
                                        DATA KUNJUNGAN KULINER TAHUN {{$tahun}}
                                    @elseif(request()->get('kategori') == 'akomodasi')
                                        DATA KUNJUNGAN AKOMODASI TAHUN {{$tahun}}
                                    @endif
                                </h2>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: left; text-transform: uppercase;" rowspan="2">Nama</th>
                            <th style="text-align: center; text-transform: uppercase;" rowspan="2">Total</th>
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center; text-transform: uppercase;" colspan="2">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                                <th style="text-align: center; text-transform: uppercase;" colspan="2">{{ $negara->wismannegara_name }}</th>
                            @endforeach
                        </tr>
                        <tr>
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
                        @if(request()->get('kategori') == 'semua')
                            <!-- Menampilkan Semua Kategori -->
                            @foreach (array_merge($wisataList->toArray(), $akomodasiList->toArray(), $kulinerList->toArray()) as $data)
    <tr>
        <td>
            <p style="text-align: left; text-transform: uppercase;">
                <span>
                    {{ $data['namawisata'] ?? $data['namakuliner'] ?? $data['namaakomodasi'] }}
                    @if(isset($data['namawisata']))
                        <strong> (Wisata)</strong>
                    @elseif(isset($data['namakuliner']))
                        <strong> (Kuliner)</strong>
                    @elseif(isset($data['namaakomodasi']))
                        <strong> (Akomodasi)</strong>
                    @endif
                </span>
            </p>
        </td>

        <td style="text-align: center; text-transform: uppercase;">
            {{-- {{ $data['jumlah_laki_laki'] + $data['jumlah_perempuan'] + $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'] }} --}}
        </td>

        <!-- Data berdasarkan Kelompok -->
        @foreach ($kelompok as $namaKelompok)
            <td style="text-align: center; text-transform: uppercase;">
                <!-- Periksa apakah 'kelompok' ada dalam data -->
                {{ isset($data['kelompok']) ? $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') : 0 }}
            </td>
            <td style="text-align: center; text-transform: uppercase;">
                {{ isset($data['kelompok']) ? $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') : 0 }}
            </td>
        @endforeach

        @foreach ($wismannegara as $negara)
            <td style="text-align: center; text-transform: uppercase;">
                {{ isset($data['wismannegara']) ? $data['wismannegara']->get($negara->id, collect())->sum('jml_wisman_laki') : 0 }}
            </td>
            <td style="text-align: center; text-transform: uppercase;">
                {{ isset($data['wismannegara']) ? $data['wismannegara']->get($negara->id, collect())->sum('jml_wisman_perempuan') : 0 }}
            </td>
        @endforeach
    </tr>
@endforeach
                        @elseif(request()->get('kategori') == 'wisata')
                            @forelse ($kunjungan as $wisata)
                                <tr>
                                    <td>
                                        <p style="text-align: left; text-transform: uppercase;">
                                            <span>{{ $wisata['item']->namawisata ?? 'Nama Wisata Tidak Tersedia' }}</span>
                                        </p>
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $wisata['jumlah_laki_laki'] + $wisata['jumlah_perempuan'] + $wisata['jml_wisman_laki'] + $wisata['jml_wisman_perempuan'] }}
                                    </td>
                                    <!-- Data berdasarkan Kelompok -->
                                    @foreach ($kelompok as $namaKelompok)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $wisata['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $wisata['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0 }}</td>
                                    @endforeach
                                    @foreach ($wismannegara as $negara)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $wisata['wismannegara']->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $wisata['wismannegara']->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0 }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}" class="text-center">No Data Available</td>
                                </tr>
                            @endforelse
                        @elseif(request()->get('kategori') == 'akomodasi')
                            @forelse ($kunjungan as $akomodasi)
                                <tr>
                                    <td>
                                        <p style="text-align: left; text-transform: uppercase;">
                                            <span>{{ $akomodasi['item']->namaakomodasi ?? 'Nama Wisata Tidak Tersedia' }}</span>
                                        </p>
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $akomodasi['jumlah_laki_laki'] + $akomodasi['jumlah_perempuan'] + $akomodasi['jml_wisman_laki'] + $akomodasi['jml_wisman_perempuan'] }}
                                    </td>
                                    <!-- Data berdasarkan Kelompok -->
                                    @foreach ($kelompok as $namaKelompok)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $akomodasi['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $akomodasi['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0 }}</td>
                                    @endforeach
                                    @foreach ($wismannegara as $negara)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $akomodasi['wismannegara']->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $akomodasi['wismannegara']->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0 }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}" class="text-center">No Data Available</td>
                                </tr>
                            @endforelse
                        @elseif(request()->get('kategori') == 'kuliner')
                            @forelse ($kunjungan as $kuliner)
                                <tr>
                                    <td>
                                        <p style="text-align: left; text-transform: uppercase;">
                                            <span>{{ $kuliner['item']->namakuliner ?? 'Nama Wisata Tidak Tersedia' }}</span>
                                        </p>
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $kuliner['jumlah_laki_laki'] + $kuliner['jumlah_perempuan'] + $kuliner['jml_wisman_laki'] + $kuliner['jml_wisman_perempuan'] }}
                                    </td>
                                    <!-- Data berdasarkan Kelompok -->
                                    @foreach ($kelompok as $namaKelompok)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $kuliner['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $kuliner['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0 }}</td>
                                    @endforeach
                                    @foreach ($wismannegara as $negara)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $kuliner['wismannegara']->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $kuliner['wismannegara']->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0 }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}" class="text-center">No Data Available</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                    
                  
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
