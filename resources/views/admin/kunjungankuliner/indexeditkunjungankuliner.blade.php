@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">

    <div class="container-fluid">

      

        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("admin.kunjungankuliner.createwisnu") }}">
                    Tambah Data
                </a>
                <button class="btn btn-primary" id="export-to-excel">Export to Excel</button> <!-- Tombol Export -->
                <button class="btn btn-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->

            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr><th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                        
                        <h2 style="text-align: center; text-transform: uppercase;">
                            Rekap Data Kunjungan {{$kuliner->first()->namakuliner}}
                            Tahun {{ $tahun }} Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        </h2>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="3">Tanggal</th>
                        <th rowspan="3">Total</th>
                        <th rowspan="3">Aksi</th>
                        <th colspan="{{ count($kelompok) * 2 }}" style="text-align: center;">Kuliner Nusantara</th>
                        <th colspan="{{ count($wismannegara) * 2 }}" style="text-align: center;">Kuliner Mancanegara</th>
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
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</td>
                            <td>
                                {{ $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('admin.kunjungankuliner.edit', ['kuliner_id' => $hash->encode($kuliner->first()->id),'tanggal_kunjungan' => $tanggal]) }}">
                                    <i class="fas fa-pencil-alt"></i> Ubah
                                </a>
                                <a href="{{ route('admin.kunjungankuliner.delete', ['kuliner_id' => $hash->encode($kuliner->first()->id), 'tanggal_kunjungan' => $tanggal]) }}"
                                    class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data kunjungan tanggal {{ $tanggal }}?')) { document.getElementById('delete-form').submit(); }">
                                     <i class="fas fa-trash"></i> Hapus
                                 </a>
                                 
                                 <form id="delete-form" action="{{ route('admin.kunjungankuliner.delete', ['kuliner_id' => $hash->encode($kuliner->first()->id), 'tanggal_kunjungan' => $tanggal]) }}" method="POST" style="display:none;">
                                     @csrf
                                     @method('DELETE')
                                 </form>
                                 
                                
                                
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
        var sheet = XLSX.utils.table_to_book(table, { sheet: 'Kunjungan Kuliner' }); // Konversi tabel menjadi buku Excel
        XLSX.writeFile(sheet, 'Kunjungan_Kuliner_' + new Date().toISOString() + '.xlsx'); // Unduh file Excel
    });
</script>
@endsection
