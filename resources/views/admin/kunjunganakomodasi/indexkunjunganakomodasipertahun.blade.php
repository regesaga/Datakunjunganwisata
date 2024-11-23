@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Tahun dan Akomodasi -->
        <form method="GET" action="{{ route('admin.kunjunganakomodasi.indexkunjunganakomodasipertahun') }}">
            <div class="row">
                <div class="col-lg-3">
                    <label style="text-align: center; text-transform: uppercase;" for="akomodasi_id" class="form-label">Akomodasi</label>
                    <select name="akomodasi_id" class="form-control select2">
                        <option style="text-align: center; text-transform: uppercase;" value="">SEMUA TEMPAT AKOMODASI</option>
                        @foreach($akomodasi as $item)
                            <option style="text-align: center; text-transform: uppercase;" value="{{ $hash->encode($item->id) }}" 
                                {{ request('akomodasi_id') == $hash->encode($item->id) ? 'selected' : '' }}>
                                {{ $item->namaakomodasi }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div class="col-lg-3">
                    <label style="text-align: center; text-transform: uppercase;" for="tahun" class="form-label">Tahun</label>
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
                <a class="btn btn-outline-success btn-sm" href="{{ route('admin.kunjunganakomodasi.createwisnu') }}">
                    Tambah Data
                </a>
                <button class="btn btn-outline-success" id="export-to-excel">Export to Excel</button> <!-- Tombol Export -->
                <button class="btn btn-outline-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->

            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                            <h2 style="text-align: center; text-transform: uppercase;">
                               
                                Data Kunjungan {{ $akomodasiTerpilih ? $akomodasiTerpilih->first()->namaakomodasi : 'Semua Tempat Akomodasi' }} Tahun {{ $tahun }}
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
                    @php
                    // Cek apakah semua nilai pada tanggal tersebut adalah 0
                    $isZero = ($dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan']) == 0;
                    foreach ($kelompok as $namaKelompok) {
                        if ($dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') > 0 || $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') > 0) {
                            $isZero = false;
                            break;
                        }
                    }
                    if ($dataBulan['jml_wisman_laki'] > 0 || $dataBulan['jml_wisman_perempuan'] > 0) {
                        $isZero = false;
                    }
                @endphp
        <tr class="{{  $isZero ? 'bg-navy color-palette' : '' }}">
                            <td>
                                @if($akomodasi_id)
    <a style="text-align: left; text-transform: uppercase;" href="{{ route('admin.kunjunganakomodasi.indexeditkunjunganakomodasi', [
        'akomodasi_id' => $hash->encode($akomodasi_id), 
        'bulan' => $month,
        'tahun' => $tahun
    ]) }}">
    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
    </a>
@else
                                   <p style="text-align: left; text-transform: uppercase;" >{{ DateTime::createFromFormat('!m', $month)->format('F') }}</p>
                                @endif
                            </td>
                            

                            <td style="text-align: center; text-transform: uppercase;">
                                {{ $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'] }}
                            </td>
                            @foreach ($kelompok as $namaKelompok)
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') }}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') }}</td>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') }}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') }}</td>
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
            filename:     'Kunjungan_Akomodasi_' + new Date().toISOString() + '.pdf',
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
        var sheet = XLSX.utils.table_to_book(table, { sheet: 'Kunjungan Akomodasi' }); // Konversi tabel menjadi buku Excel
        XLSX.writeFile(sheet, 'Kunjungan_Akomodasi_' + new Date().toISOString() + '.xlsx'); // Unduh file Excel
    });
</script>
@endsection

