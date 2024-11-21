@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('account.wisata.kunjunganwisata.filterwismanbulan') }}">
            <div class="row">
                <div class="col-lg-4">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun"  class="form-control select2" style="width: 100%;">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select id="bulan" name="bulan"  class="form-control select2" style="width: 100%;">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
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

        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("account.wisata.kunjunganwisata.createwisnu") }}">
                    Tambah Data
                </a>
                <button class="btn btn-primary" id="export-to-excel">Cetak Excel </button> <!-- Tombol Export -->
                <button class="btn btn-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->
            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <th colspan="{{ 3 +  (count($wismannegara) * 2) }}">
                        <h2 style="text-align: center; text-transform: uppercase;">
                            Data Kunjungan Wisatawan Mancanegara {{$wisata->namawisata}} Tahun {{ $tahun }} Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        </h2>
                    </th>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">Total</th>
                      
                        @foreach ($wismannegara as $negara)
                            <th colspan="2">{{ $negara->wismannegara_name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                      
                        @foreach ($wismannegara as $negara)
                            <th>Laki - Laki</th>
                            <th>Perempuan</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungan as $tanggal => $dataTanggal)
                        @php
                            // Hitung total jumlah wisatawan untuk baris ini
                            $totalWisman = $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'];
                            
                            foreach ($wismannegara as $negara) {
                                $totalWisman += $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                                $totalWisman += $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan');
                            }
                
                            // Cek apakah total jumlah adalah 0
                            $isZero = $totalWisman === 0;
                        @endphp
                        <tr class="{{ $isZero ? 'bg-warning' : '' }}">
                            <td>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</td>
                            <td>
                                {{ $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                            </td>
                
                            @foreach ($wismannegara as $negara)
                                <td>{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') }}</td>
                                <td>{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                

                <tfoot>
                    <tr>
                        <th>Total Keseluruhan</th>
                        <th>
                            {{ $kunjungan->sum(function($dataTanggal) {
                                return $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'];
                            }) }}
                        </th>

                        @foreach ($wismannegara as $negara)
                            <th>{{ $kunjungan->sum(function($dataTanggal) use ($negara) {
                                return $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                            }) }}</th>
                            <th>{{ $kunjungan->sum(function($dataTanggal) use ($negara) {
                                return $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan');
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
