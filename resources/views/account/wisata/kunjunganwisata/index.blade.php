@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h2>Laporan Kunjungan Wisatawan</h2>
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("account.wisata.kunjunganwisata.createwisnu") }}">
                    Tambah Data
                </a>
            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">Total</th>
                        <th rowspan="2">Aksi</th>
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
                                <a class="btn btn-info btn-sm" href="{{ route('account.wisata.kunjunganwisata.edit', ['wisata_id' => $hash->encode($wisata->id),'tanggal_kunjungan' => $tanggal]) }}">
                                    <i class="fas fa-pencil-alt"></i> Ubah
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
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

                <!-- TFOOT untuk total keseluruhan -->
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
@section('scripts')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
@endsection
