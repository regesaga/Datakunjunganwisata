@extends('layouts.datakunjungan.Homedatakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Tahun dan Wisata -->
        <form action="{{ route('rekapsemua') }}" method="GET">
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
                                    @elseif(request()->get('kategori') == 'event')
                                    DATA KUNJUNGAN EVENT TAHUN{{$tahun}}
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
                                 <td style="text-align: center; text-transform: uppercase;">
                                    <p style="text-align: left; text-transform: uppercase;">
                                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                    </p>
                                </td>
                    
                                <td style="text-align: center; text-transform: uppercase;">
                                   {{ number_format(($dataBulan['jumlah_laki_laki'] ?? 0) + ($dataBulan['jumlah_perempuan'] ?? 0) + ($dataBulan['jml_wisman_laki'] ?? 0) + ($dataBulan['jml_wisman_perempuan'] ?? 0), 0, ',', '.') }}

                                </td>
                    
                                @foreach ($kelompok as $namaKelompok)
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ number_format(($dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?? 0), 0, ',', '.') }}

                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ number_format(($dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?? 0), 0, ',', '.') }}

                                    </td>
                                @endforeach
                    
                                @foreach ($wismannegara as $negara)
                                    <td style="text-align: center; text-transform: uppercase;">
                                       {{ number_format(($dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') ?? 0), 0, ',', '.') }}

                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                       {{ number_format(($dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') ?? 0), 0, ',', '.') }}

                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    
                   <tfoot>
    <tr>
        <th style="text-align: left; text-transform: uppercase;">Total Keseluruhan</th>
        <th style="text-align: center; text-transform: uppercase;">
            {{ number_format(collect($kunjungan)->sum(function($dataBulan) {
                return $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'];
            }), 0, ',', '.') }}
        </th>
        @foreach ($kelompok as $namaKelompok)
            <th style="text-align: center; text-transform: uppercase;">
                {{ number_format(collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                    return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki');
                }), 0, ',', '.') }}
            </th>
            <th style="text-align: center; text-transform: uppercase;">
                {{ number_format(collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                    return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan');
                }), 0, ',', '.') }}
            </th>
        @endforeach
        @foreach ($wismannegara as $negara)
            <th style="text-align: center; text-transform: uppercase;">
                {{ number_format(collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                    return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                }), 0, ',', '.') }}
            </th>
            <th style="text-align: center; text-transform: uppercase;">
                {{ number_format(collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                    return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan');
                }), 0, ',', '.') }}
            </th>
        @endforeach
    </tr>
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
