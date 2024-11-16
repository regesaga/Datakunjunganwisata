@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Tahun -->
        <form method="GET" action="{{ route('account.wisata.kunjunganwisata.indexkunjunganwisatapertahun') }}">
            <div class="row">
                <div class="col-lg-2">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun" class="form-control select2" style="width: 100%;">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                <a class="btn btn-success" href="{{ route('account.wisata.kunjunganwisata.createwisnu') }}">
                    Tambah Data
                </a>
                <button class="btn btn-primary" id="export-to-excel">Export to Excel</button> <!-- Tombol Export -->
                <button class="btn btn-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->

            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="3">Bulan</th>
                        <th rowspan="3">Total</th>
                        <th colspan="{{ count($kelompok) * 2 }}" style="text-align: center;">Wisata Nusantara</th>
                        <th colspan="{{ count($wismannegara) * 2 }}" style="text-align: center;">Wisata Mancanegara</th>
                    </tr>
                    <tr>
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
                            <td>{{ DateTime::createFromFormat('!m', $month)->format('F') }}</td>
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
    
