@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">

        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('admin.kunjungankuliner.index') }}">
            <div class="row">
                <div class="col-lg-3">
                    <label style="text-align: center; text-transform: uppercase;" for="category" class="form-label">Kategori</label>
                    <select name="categorykuliner_id" class="form-control select2">
                        <option style="text-align: center; text-transform: uppercase;" value="">SEMUA TEMPAT KULINER</option>
                        @foreach($kategoriKuliner as $kategori)
                            <option style="text-align: center; text-transform: uppercase;" value="{{ $kategori->id }}" {{ request('categorykuliner_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <label style="text-align: center; text-transform: uppercase;" for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun" class="form-control select2">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option style="text-align: center; text-transform: uppercase;" value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
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
                    <button type="submit" class="btn btn-info">Terapkan Filter</button>
                </div>
            </div>
        </form>

        <!-- Tabel Data Kunjungan -->
        <div class="card mt-4">
            <div class="card-header">
                <a class="btn btn-outline-success btn-sm" href="{{ route('admin.kunjungankuliner.createwisnu') }}">
                    Tambah Data
                </a>
                <button class="btn btn-outline-success" id="export-to-excel">Export to Excel</button> <!-- Tombol Export -->
                <button class="btn btn-outline-danger" id="export-to-pdf">Export to PDF</button> <!-- Tombol Export PDF -->
            </div>
          
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                            <h3 style="text-align: center; text-transform: uppercase;">Rekapan Kunjungan Bulan  {{ $bulanIndo[(int)$bulan] }}  Tahun {{ $tahun }}</h3>
                            <h2 style="text-align: center; text-transform: uppercase;">{{ $kategoriKuliner->find($categorykuliner_id)->category_name ?? 'Semua Tempat Kuliner' }} </h2>
                            </th>
                        </tr>
                     
                        <tr>
                            <th rowspan="3" style="text-align: left; text-transform: uppercase;">Kuliner</th>
                            <th rowspan="3" style="text-align: center; text-transform: uppercase;">Total</th>
                            <th colspan="{{ count($kelompok) * 2 }}" style="text-align: center; text-transform: uppercase;">WISATAWAN Nusantara</th>
                            <th colspan="2" style="text-align: center; text-transform: uppercase;">WISATAWAN Mancanegara</th>
                        </tr>
                        <tr>
                            @foreach ($kelompok as $namaKelompok)
                                <th colspan="2" style="text-align: center; text-transform: uppercase;">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                            @endforeach
                            <th colspan="2" style="text-align: center; text-transform: uppercase;">Total WISATAWAN Mancanegara</th>
                        </tr>
                        <tr>
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center; text-transform: uppercase;">L</th>
                                <th style="text-align: center; text-transform: uppercase;">P</th>
                            @endforeach
                            <th style="text-align: center; text-transform: uppercase;">Laki - Laki</th>
                            <th style="text-align: center; text-transform: uppercase;">Perempuan</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($kunjungan as $dataTanggal)
                        @php
                        // Cek apakah semua nilai pada tanggal tersebut adalah 0
                        $isZero = ($dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan']) == 0;
                        foreach ($kelompok as $namaKelompok) {
                            if ($dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') > 0 || $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') > 0) {
                                $isZero = false;
                                break;
                            }
                        }
                        if ($dataTanggal['jml_wisman_laki'] > 0 || $dataTanggal['jml_wisman_perempuan'] > 0) {
                            $isZero = false;
                        }
                    @endphp
                        <tr class="{{  $isZero ? 'bg-navy color-palette' : '' }}">
                                                      


                                 <td style="text-align: center; text-transform: uppercase;">  <a  href="{{ route('admin.kunjungankuliner.indexeditkunjungankuliner', [
                                    'kuliner_id' => $hash->encode($dataTanggal['kuliner']->id), 
                                    'bulan' => $bulan,
                                    'tahun' => $tahun
                                ]) }}" style="text-align: center; text-transform: uppercase;">{{ $dataTanggal['kuliner']->namakuliner }}
                               
                                </a>
                                <td style="text-align: center; text-transform: uppercase;">
                                    {{ $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                                </td>
                                <!-- Data berdasarkan Kelompok -->
                                @foreach ($kelompok as $namaKelompok)
                                    <td style="text-align: center; text-transform: uppercase;">{{ $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0 }}</td>
                                    <td style="text-align: center; text-transform: uppercase;">{{ $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0 }}</td>
                                @endforeach
                                <!-- Data Total Kuliner Mancanegara -->
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataTanggal['jml_wisman_laki'] ?: 0 }}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataTanggal['jml_wisman_perempuan'] ?: 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + count($kelompok) * 2 + 2 }}">Tidak ada data tersedia untuk filter yang dipilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: left; text-transform: uppercase;">Total</th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ $kunjungan->sum(fn($dataTanggal) => 
                                    $dataTanggal['jumlah_laki_laki'] + 
                                    $dataTanggal['jumlah_perempuan'] + 
                                    $dataTanggal['jml_wisman_laki'] + 
                                    $dataTanggal['jml_wisman_perempuan']
                                ) }}
                            </th>
                            @foreach ($kelompok as $namaKelompok)
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ $kunjungan->sum(fn($dataTanggal) => 
                                        $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') ?: 0
                                    ) }}
                                </th>
                                <th style="text-align: center; text-transform: uppercase;">
                                    {{ $kunjungan->sum(fn($dataTanggal) => 
                                        $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') ?: 0
                                    ) }}
                                </th>
                            @endforeach
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ $kunjungan->sum(fn($dataTanggal) => $dataTanggal['jml_wisman_laki'] ?: 0) }}
                            </th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ $kunjungan->sum(fn($dataTanggal) => $dataTanggal['jml_wisman_perempuan'] ?: 0) }}
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
        var sheet = XLSX.utils.table_to_book(table, { sheet: 'Kunjungan Kuliner' }); // Konversi tabel menjadi buku Excel
        XLSX.writeFile(sheet, 'Kunjungan_Kuliner_' + new Date().toISOString() + '.xlsx'); // Unduh file Excel
    });
</script>
@endsection
