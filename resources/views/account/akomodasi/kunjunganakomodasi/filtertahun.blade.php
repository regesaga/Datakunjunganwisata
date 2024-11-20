@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="card-header">
            <form action="{{ route('account.akomodasi.kunjunganakomodasi.filtertahun') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="year" class="form-label">Tahun</label>
                        <select id="year" name="year" class="form-control select2" style="width: 100%;">
                            @for($y = date('Y'); $y >= 2023; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-info">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>
       
        <button class="btn btn-primary" id="export-to-excel">Cetak Excel </button> <!-- Tombol Export -->
        <button class="btn btn-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->

        <!-- Tabel Data Kunjungan Per Bulan -->
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    
                    <thead>
                        <tr><th colspan="6">
                            <h2 style="text-align: center; text-transform: uppercase;">
                                Rekapan Data Kunjungan {{$akomodasi->namaakomodasi}} Tahun {{ $year }}
                            </h2>
                            </th>
                        </tr>
                        <tr>
                            <th>Bulan</th>
                            <th>Total Laki-Laki Domestik</th>
                            <th>Total Perempuan Domestik</th>
                            <th>Total Laki-Laki Mancanegara</th>
                            <th>Total Perempuan Mancanegara</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(range(1, 12) as $month)
                            <tr>
                                <td>{{ DateTime::createFromFormat('!m', $month)->format('F') }}</td>
                                <td>{{ $kunjungan[$month]['total_laki_laki'] ?? 0 }}</td>
                                <td>{{ $kunjungan[$month]['total_perempuan'] ?? 0 }}</td>
                                <td>{{ $kunjungan[$month]['total_wisman_laki'] ?? 0 }}</td>
                                <td>{{ $kunjungan[$month]['total_wisman_perempuan'] ?? 0 }}</td>
                                <td>
                                    {{ ($kunjungan[$month]['total_laki_laki'] ?? 0) + 
                                       ($kunjungan[$month]['total_perempuan'] ?? 0) + 
                                       ($kunjungan[$month]['total_wisman_laki'] ?? 0) + 
                                       ($kunjungan[$month]['total_wisman_perempuan'] ?? 0) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total Keseluruhan</th>
                            <th>{{ $totalKeseluruhan['total_laki_laki'] }}</th>
                            <th>{{ $totalKeseluruhan['total_perempuan'] }}</th>
                            <th>{{ $totalKeseluruhan['total_wisman_laki'] }}</th>
                            <th>{{ $totalKeseluruhan['total_wisman_perempuan'] }}</th>
                            <th>
                                {{ $totalKeseluruhan['total_laki_laki'] + 
                                   $totalKeseluruhan['total_perempuan'] + 
                                   $totalKeseluruhan['total_wisman_laki'] + 
                                   $totalKeseluruhan['total_wisman_perempuan'] }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- DataTables & Plugins -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script>
    document.getElementById('export-to-pdf').addEventListener('click', function () {
        var element = document.getElementById('example1');
        var opt = {
            margin:       [10, 10, 10, 10],  // Menambahkan margin atas, kanan, bawah, kiri (dalam mm)
            filename:     'Kunjungan_Wisata_' + new Date().toISOString() + '.pdf',
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

