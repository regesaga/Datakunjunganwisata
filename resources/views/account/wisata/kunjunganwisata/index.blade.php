@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">

    <div class="container-fluid">

        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('account.wisata.kunjunganwisata.index') }}">
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
                <button class="btn btn-primary" id="export-to-excel">Export to Excel</button> <!-- Tombol Export -->
                <button class="btn btn-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->

            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr><th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                        <h2 style="text-align: center; text-transform: uppercase;">
                            Rekap Data Kunjungan {{$wisata->namawisata}} Tahun {{ $tahun }} Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        </h2>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="3">Tanggal</th>
                        <th rowspan="3">Total</th>
                        <th rowspan="3">Aksi</th>
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
                    @foreach ($kunjungan as $tanggal => $dataTanggal)
                        @php
                            // Periksa apakah semua nilai untuk satu tanggal adalah 0
                            $isZero = ($dataTanggal['jumlah_laki_laki'] == 0 && 
                                       $dataTanggal['jumlah_perempuan'] == 0 && 
                                       $dataTanggal['jml_wisman_laki'] == 0 && 
                                       $dataTanggal['jml_wisman_perempuan'] == 0 &&
                                       $dataTanggal['kelompok']->every(function($kelompok) {
                                           return $kelompok->sum('jumlah_laki_laki') == 0 && $kelompok->sum('jumlah_perempuan') == 0;
                                       }) &&
                                       $dataTanggal['wisman_by_negara']->every(function($wismanNegara) {
                                           return $wismanNegara->sum('jml_wisman_laki') == 0 && $wismanNegara->sum('jml_wisman_perempuan') == 0;
                                       }));
                        @endphp
                        
                        <tr class="{{ $isZero ? 'bg-warning' : '' }}">
                            <td>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</td>
                            <td>
                                {{ $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                            </td>
                            <td>
                                @if ($isZero)
                                    <!-- Show "Belum Input" when row is highlighted -->
                                    <span class="text-muted">Belum Input</span>
                                @else
                                    <!-- Show the buttons if the row is not highlighted -->
                                    <a class="btn btn-info btn-sm" href="{{ route('account.wisata.kunjunganwisata.edit', ['wisata_id' => $hash->encode($wisata->id),'tanggal_kunjungan' => $tanggal]) }}">
                                        <i class="fas fa-pencil-alt"></i> Ubah
                                    </a>
                                    <a href="{{ route('account.wisata.kunjunganwisata.delete', ['wisata_id' => $hash->encode($wisata->id), 'tanggal_kunjungan' => $tanggal]) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data kunjungan tanggal {{ $tanggal }}?')) { document.getElementById('delete-form').submit(); }">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                    <form id="delete-form" action="{{ route('account.wisata.kunjunganwisata.delete', ['wisata_id' => $hash->encode($wisata->id), 'tanggal_kunjungan' => $tanggal]) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                    
                            @foreach ($kelompok as $namaKelompok)
                                <td>{{ $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_laki_laki') }}</td>
                                <td>{{ $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_perempuan') }}</td>
                            @endforeach
                    
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
                                return $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'];
                            }) }}
                        </th>
                        <th></th>

                        @foreach ($kelompok as $namaKelompok)
                            <th>{{ $kunjungan->sum(function($dataTanggal) use ($namaKelompok) {
                                return $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_laki_laki');
                            }) }}</th>
                            <th>{{ $kunjungan->sum(function($dataTanggal) use ($namaKelompok) {
                                return $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_perempuan');
                            }) }}</th>
                        @endforeach

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
