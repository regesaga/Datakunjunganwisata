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
                        <option value="event" {{ request()->get('kategori') == 'event' ? 'selected' : '' }}>EVENT</option>
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
                                        DATA KUNJUNGAN TAHUN {{$tahun}} BULAN {{ $bulanIndo[(int)$bulan] }} 
                                    @elseif(request()->get('kategori') == 'wisata')
                                        DATA KUNJUNGAN WISATA TAHUN {{$tahun}} BULAN {{ $bulanIndo[(int)$bulan] }} 
                                    @elseif(request()->get('kategori') == 'kuliner')
                                        DATA KUNJUNGAN KULINER TAHUN {{$tahun}} BULAN {{ $bulanIndo[(int)$bulan] }} 
                                    @elseif(request()->get('kategori') == 'akomodasi')
                                        DATA KUNJUNGAN AKOMODASI TAHUN {{$tahun}} {{ $bulanIndo[(int)$bulan] }} 
                                    @elseif(request()->get('kategori') == 'event')
                                        DATA KUNJUNGAN EVENT TAHUN {{$tahun}} {{ $bulanIndo[(int)$bulan] }} 
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
                            <!-- Menampilkan Semua Kategori (Wisata, Kuliner, Akomodasi) -->
                            @forelse ($kunjungan as $data)
                            <tr>
                                 <td style="text-align: center; text-transform: uppercase;">
                                    <span>
                                        {{-- Mengakses 'namawisata' langsung dari objek 'item' --}}
                                        {{ $data['item']->namawisata ?? $data['item']->namakuliner ?? $data['item']->namaakomodasi ?? $data['item']->title ??'Unknown' }}
                                        @if(isset($data['item']->namawisata))
                                            <strong> (Wisata)</strong>
                                        @elseif(isset($data['item']->namakuliner))
                                            <strong> (Kuliner)</strong>
                                        @elseif(isset($data['item']->namaakomodasi))
                                            <strong> (Akomodasi)</strong>
                                        @elseif(isset($data['item']->title))
                                            <strong> (Event)</strong>
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    {{ $data['jumlah_laki_laki'] + $data['jumlah_perempuan'] + $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'] }}
                                </td>
                                <!-- Data berdasarkan Kelompok -->
                                @foreach ($kelompok as $namaKelompok)
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0 }}
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $data['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0 }}
                                    </td>
                                @endforeach
                                <!-- Data berdasarkan Negara Wisman -->
                                @foreach ($wismannegara as $negara)
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $data['wismannegara']->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0 }}
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $data['wismannegara']->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0 }}
                                    </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}" class="text-center">No Data Available</td>
                            </tr>
                            @endforelse
                        @elseif(request()->get('kategori') == 'wisata')
                            @forelse ($kunjungan as $wisata)
                                <tr>
                                     <td style="text-align: center; text-transform: uppercase;">
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
                                     <td style="text-align: center; text-transform: uppercase;">
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
                                     <td style="text-align: center; text-transform: uppercase;">
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
                        @elseif(request()->get('kategori') == 'event')
                            @forelse ($kunjungan as $event)
                                <tr>
                                     <td style="text-align: center; text-transform: uppercase;">
                                        <p style="text-align: left; text-transform: uppercase;">
                                            <span>{{ $event['item']->title ?? 'Nama Wisata Tidak Tersedia' }}</span>
                                        </p>
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $event['jumlah_laki_laki'] + $event['jumlah_perempuan'] + $event['jml_wisman_laki'] + $event['jml_wisman_perempuan'] }}
                                    </td>
                                    <!-- Data berdasarkan Kelompok -->
                                    @foreach ($kelompok as $namaKelompok)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $event['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $event['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0 }}</td>
                                    @endforeach
                                    @foreach ($wismannegara as $negara)
                                        <td style="text-align: center; text-transform: uppercase;">{{ $event['wismannegara']->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0 }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ $event['wismannegara']->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0 }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}" class="text-center">No Data Available</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                    <tfoot>
                        @if(request()->get('kategori') == 'semua')
                            <!-- Menampilkan Semua Kategori -->
                            <tr>
                                <th style="text-align: left; text-transform: uppercase;">Total</th>
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ collect($kunjungan)->sum(fn($data) => 
                                        $data['jumlah_laki_laki'] + 
                                        $data['jumlah_perempuan'] + 
                                        $data['jml_wisman_laki'] + 
                                        $data['jml_wisman_perempuan']
                                    ) }}
                                </th>
                                @foreach ($kelompok as $namaKelompok)
                                    <th style="text-align: center; text-transform: uppercase;">
                                        {{ collect($kunjungan)->sum(fn($data) => 
                                            collect($data['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0
                                        ) }}
                                    </th>
                                    <th style="text-align: center; text-transform: uppercase;">
                                        {{ collect($kunjungan)->sum(fn($data) => 
                                            collect($data['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0
                                        ) }}
                                    </th>
                                @endforeach
                                @foreach ($wismannegara as $neara)
                                    <th style="text-align: center; text-transform: uppercase;">
                                        {{ collect($kunjungan)->sum(fn($data) => 
                                            collect($data['wismannegara'])->get($neara->id, collect())->sum('jml_wisman_laki') ?: 0
                                        ) }}
                                    </th>
                                    <th style="text-align: center; text-transform: uppercase;">
                                        {{ collect($kunjungan)->sum(fn($data) => 
                                            collect($data['wismannegara'])->get($neara->id, collect())->sum('jml_wisman_perempuan') ?: 0
                                        ) }}
                                    </th>
                                @endforeach
                            </tr>
                        @elseif(request()->get('kategori') == 'wisata')
                            <!-- Repeat similar changes for other categories -->
                            <tr>
                                <th style="text-align: left; text-transform: uppercase;">Total</th>
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ collect($kunjungan)->sum(fn($wisata) => 
                                        $wisata['jumlah_laki_laki'] + 
                                        $wisata['jumlah_perempuan'] + 
                                        $wisata['jml_wisman_laki'] + 
                                        $wisata['jml_wisman_perempuan']
                                    ) }}
                                </th>
                                @foreach ($kelompok as $namaKelompok)
                                    <th style="text-align: center; text-transform: uppercase;">
                                        {{ collect($kunjungan)->sum(fn($wisata) => 
                                            collect($wisata['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0
                                        ) }}
                                    </th>
                                    <th style="text-align: center; text-transform: uppercase;">
                                        {{ collect($kunjungan)->sum(fn($wisata) => 
                                            collect($wisata['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0
                                        ) }}
                                    </th>
                                @endforeach
                                @foreach ($wismannegara as $negara)
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ collect($kunjungan)->sum(fn($wisata) => 
                                        collect($wisata['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0
                                    ) }}
                                </th>
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ collect($kunjungan)->sum(fn($wisata) => 
                                        collect($wisata['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0
                                    ) }}
                                </th>
                            @endforeach

                             
                            </tr>
                        @elseif(request()->get('kategori') == 'kuliner')
                        <!-- Repeat similar changes for other categories -->
                        <tr>
                            <th style="text-align: left; text-transform: uppercase;">Total</th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(fn($kuliner) => 
                                    $kuliner['jumlah_laki_laki'] + 
                                    $kuliner['jumlah_perempuan'] + 
                                    $kuliner['jml_wisman_laki'] + 
                                    $kuliner['jml_wisman_perempuan']
                                ) }}
                            </th>
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ collect($kunjungan)->sum(fn($kuliner) => 
                                        collect($kuliner['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0
                                    ) }}
                                </th>
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ collect($kunjungan)->sum(fn($kuliner) => 
                                        collect($kuliner['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0
                                    ) }}
                                </th>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(fn($kuliner) => 
                                    collect($kuliner['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0
                                ) }}
                            </th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(fn($kuliner) => 
                                    collect($kuliner['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0
                                ) }}
                            </th>
                        @endforeach

                         
                        </tr>
                    @elseif(request()->get('kategori') == 'akomodasi')
                    <!-- Repeat similar changes for other categories -->
                    <tr>
                        <th style="text-align: left; text-transform: uppercase;">Total</th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(fn($akomodasi) => 
                                $akomodasi['jumlah_laki_laki'] + 
                                $akomodasi['jumlah_perempuan'] + 
                                $akomodasi['jml_wisman_laki'] + 
                                $akomodasi['jml_wisman_perempuan']
                            ) }}
                        </th>
                        @foreach ($kelompok as $namaKelompok)
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(fn($akomodasi) => 
                                    collect($akomodasi['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0
                                ) }}
                            </th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(fn($akomodasi) => 
                                    collect($akomodasi['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0
                                ) }}
                            </th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(fn($akomodasi) => 
                                collect($akomodasi['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0
                            ) }}
                        </th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(fn($akomodasi) => 
                                collect($akomodasi['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0
                            ) }}
                        </th>
                    @endforeach

                     
                    </tr>
                @elseif(request()->get('kategori') == 'event')
                    <!-- Repeat similar changes for other categories -->
                    <tr>
                        <th style="text-align: left; text-transform: uppercase;">Total</th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(fn($event) => 
                                $event['jumlah_laki_laki'] + 
                                $event['jumlah_perempuan'] + 
                                $event['jml_wisman_laki'] + 
                                $event['jml_wisman_perempuan']
                            ) }}
                        </th>
                        @foreach ($kelompok as $namaKelompok)
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(fn($event) => 
                                    collect($event['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0
                                ) }}
                            </th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->sum(fn($event) => 
                                    collect($event['kelompok'])->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0
                                ) }}
                            </th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(fn($event) => 
                                collect($event['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_laki') ?: 0
                            ) }}
                        </th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(fn($event) => 
                                collect($event['wismannegara'])->get($negara->id, collect())->sum('jml_wisman_perempuan') ?: 0
                            ) }}
                        </th>
                    @endforeach

                     
                    </tr>
                @endif
                    </tfoot>
                    
                    
                    
                  
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(function () {
        const currentDate = new Date();
        const formattedDate = `${currentDate.getDate()}-${currentDate.getMonth() + 1}-${currentDate.getFullYear()}`;

        $("#example1").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            ordering: false,
            paging: false,

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('datakunjungan/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script>
    document.getElementById('export-to-pdf').addEventListener('click', function () {
        var element = document.getElementById('example1');
        var opt = {
            margin:       [10, 10, 10, 10],  // Menambahkan margin atas, kanan, bawah, kiri (dalam mm)
            filename:     'Kunjungan_Kuliner_' + new Date().toISOString() + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 3 },  // Meningkatkan kualitas gambar
            jsPDF:        { 
                unit: 'mm', 
                format: 'letter',  // Format A4
                orientation: 'landscape'  // Mengatur orientasi menjadi landscape agar lebih lebar
            }
        };

        // Menambahkan pengaturan CSS untuk menghindari pemotongan
        html2pdf().from(element).set(opt).save();
    });
</script>



<script>
    // Fungsi untuk mengekspor tabel ke file Excel
    document.getElementById('export-to-excel').addEventListener('click', function () {
        var table = document.getElementById('example1'); // Ambil tabel berdasarkan ID
        var sheet = XLSX.utils.table_to_book(table, { sheet: 'Kunjungan Wisata' }); // Konversi tabel menjadi buku Excel
        XLSX.writeFile(sheet, 'Kunjungan_Wisata_' + new Date().toISOString() + '.xlsx'); // Unduh file Excel
    });
</script>
@endsection
