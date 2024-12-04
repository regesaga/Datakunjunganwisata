@extends('layouts.datakunjungan.datakunjungan')



<style>
    
    .editable input:focus {
        background-color: #e0f7fa; /* Warna biru muda saat input difokuskan */
        border-color: #008cba; /* Warna border saat difokuskan */
    }

    .editing {
        background-color: #fff3e0; /* Warna latar belakang saat sedang diedit */
    }

    .saved {
        background-color: #c8e6c9; /* Warna latar belakang setelah disimpan */
    }

    .blurred {
        filter: blur(2px); /* Efek blur untuk baris yang tidak sedang diedit */
        pointer-events: none; /* Menonaktifkan interaksi dengan elemen yang diburamkan */
    }
</style>

@section('content')

<section class="content-header">

    <div class="container-fluid">

    <!-- Filter Tanggal -->
    <form method="GET" action="{{ route('account.akomodasi.kunjunganakomodasi.realtime') }}">
        <div class="form-group">
            <label for="filter">Pilih Periode</label>
            <select name="filter" id="filter" class="form-control" onchange="this.form.submit()">
                <option value="hari_ini" {{ $filter == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu_ini" {{ $filter == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan_ini" {{ $filter == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
            </select>
        </div>
    </form>
    <div class="card">

    <!-- Grafik Kunjungan -->
    <div id="kunjunganChart" style="width:100%; height:400px;"></div>

    <!-- Tabel Kunjungan -->
    
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                        <h2 style="text-align: center; text-transform: uppercase;">
                            @if ($filter == 'hari_ini')
                                DATA KUNJUNGAN {{ $akomodasi->namaakomodasi }} HARI INI
                            @elseif ($filter == 'minggu_ini')
                                DATA KUNJUNGAN {{ $akomodasi->namaakomodasi }} MINGGU INI
                            @elseif ($filter == 'bulan_ini')
                                DATA KUNJUNGAN {{ $akomodasi->namaakomodasi }} BULAN INI
                            @endif
                        </h2>
                    </th>
                </tr>
                <tr>
                    <th style="text-align: center; text-transform: uppercase;" rowspan="3">Tanggal</th>
                    <th style="text-align: center; text-transform: uppercase;" rowspan="3">Total</th>
                    <th style="text-align: center; text-transform: uppercase;" colspan="{{ count($kelompok) * 2 }}">Wisatawan Nusantara</th>
                    <th style="text-align: center; text-transform: uppercase;" colspan="{{ count($wismannegara) * 2 }}">Wisatawan Mancanegara</th>
                </tr>
                <tr>
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
                @foreach ($kunjungan as $tanggal => $data)
                    <tr>
                        <td style="text-align: center; text-transform: uppercase;">
                            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </td>
                        <td style="text-align: center; text-transform: uppercase;">
                            {{ $data['jumlah_laki_laki'] + $data['jumlah_perempuan'] + $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'] }}
                        </td>
        
                        @foreach ($kelompok as $namaKelompok)
                            <td  style="text-align: center; text-transform: uppercase;" data-field="jumlah_laki_laki{{ $namaKelompok->id }}" data-tanggal="{{ $tanggal }}" data-kelompok="{{ $namaKelompok->id }}">
                                {{ $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') }}
                            </td>
                            <td  style="text-align: center; text-transform: uppercase;" data-field="jumlah_perempuan{{ $namaKelompok->id }}" data-tanggal="{{ $tanggal }}" data-kelompok="{{ $namaKelompok->id }}">
                                {{ $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') }}
                            </td>
                        @endforeach
        
                        @foreach ($wismannegara as $negara)
                            <td  style="text-align: center; text-transform: uppercase;" data-field="jml_wisman_laki{{ $negara->id }}" data-tanggal="{{ $tanggal }}" data-negara="{{ $negara->id }}">
                                {{ $data['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') }}
                            </td>
                            <td  style="text-align: center; text-transform: uppercase;" data-field="jml_wisman_perempuan{{ $negara->id }}" data-tanggal="{{ $tanggal }}" data-negara="{{ $negara->id }}">
                                {{ $data['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        
            <tfoot>
                <tr>
                    <th style="text-align: center; text-transform: uppercase;">Total Keseluruhan</th>
                    <th style="text-align: center; text-transform: uppercase;">
                        {{ collect($kunjungan)->sum(function($data) {
                            return $data['jumlah_laki_laki'] + $data['jumlah_perempuan'] + $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'];
                        }) }}
                    </th>
        
                    @foreach ($kelompok as $namaKelompok)
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(function($data) use ($namaKelompok) {
                                return $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki');
                            }) }}
                        </th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(function($data) use ($namaKelompok) {
                                return $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan');
                            }) }}
                        </th>
                    @endforeach
        
                    @foreach ($wismannegara as $negara)
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(function($data) use ($negara) {
                                return $data['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                            }) }}
                        </th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(function($data) use ($negara) {
                                return $data['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan');
                            }) }}
                        </th>
                    @endforeach
                </tr>
            </tfoot>
        </table>
        
       
    </div>
</div>
<script src="{{ asset('datakunjungan/Highcharts.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('kunjunganChart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Grafik Kunjungan Akomodasi'
            },
            xAxis: {
                categories: @json($dates),
                title: {
                    text: 'Tanggal'
                }
            },
            yAxis: {
                title: {
                    text: 'Jumlah Pengunjung'
                }
            },
            series: [{
                    name: 'Wisatawan Nusantara Laki - Laki',
                    data: @json($jumlahLakiLaki)
                },
                {
                    name: 'Wisatawan Nusantara Perempuan',
                    data: @json($jumlahPerempuan)
                },
                {
                    name: 'Wisatawan Mancanegara Laki-laki',
                    data: @json($jmlWismanLaki)
                },
                {
                    name: 'Wisatawan Mancanegara Perempuan',
                    data: @json($jmlWismanPerempuan)
                }
            ]
        });
    });
</script>


@endsection

@section('scripts')

<!-- DataTables  & Plugins -->
<script src="{{ asset('datakunjungan/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

@endsection