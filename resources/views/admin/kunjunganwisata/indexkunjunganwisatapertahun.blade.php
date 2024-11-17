@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Tahun dan Wisata -->
        <form method="GET" action="{{ route('admin.kunjunganwisata.indexkunjunganwisatapertahun') }}">
            <div class="row">
                <div class="col-lg-3">
                    <label for="wisata_id" class="form-label">Wisata</label>
                    <select name="wisata_id" class="form-control select2">
                        @foreach($wisata as $item)
                            <option value="{{ $hash->encode($item->id) }}" 
                                {{ request('wisata_id') == $hash->encode($item->id) ? 'selected' : '' }}>
                                {{ $item->namawisata }}
                            </option>
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
        
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info">Terapkan Filter</button>
                </div>
            </div>
        </form>
        
        

        <div class="card mt-3">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route('admin.kunjunganwisata.createwisnu') }}">
                    Tambah Data
                </a>
            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">Bulan</th>
                        <th rowspan="2">Total</th>
                        @foreach ($kelompok as $namaKelompok)
                            <th colspan="2">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                            <th colspan="2">{{ $negara->wismannegara_name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($kelompok as $namaKelompok)
                            <th>L</th>
                            <th>P</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                            <th>L</th>
                            <th>P</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungan as $month => $dataBulan)
                        <tr>
                            <td>
                                @if($wisata_id)
    <a href="{{ route('admin.kunjunganwisata.indexeditkunjunganwisata', [
        'wisata_id' => $hash->encode($wisata_id), 
        'bulan' => $month,
        'tahun' => $tahun
    ]) }}">
        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
    </a>
@else
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                @endif
                            </td>
                            

                            <td>
                                {{ $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'] }}
                            </td>
                            @foreach ($kelompok as $namaKelompok)
                                <td>{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') }}</td>
                                <td>{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') }}</td>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                                <td>{{ $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') }}</td>
                                <td>{{ $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Keseluruhan</th>
                        <th>
                            {{ collect($kunjungan)->sum(function($dataBulan) {
                                return $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'];
                            }) }}
                        </th>
                        @foreach ($kelompok as $namaKelompok)
                            <th>{{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                                return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki');
                            }) }}</th>
                            <th>{{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                                return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan');
                            }) }}</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                            <th>{{ collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                                return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                            }) }}</th>
                            <th>{{ collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                                return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan');
                            }) }}</th>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

@endsection
