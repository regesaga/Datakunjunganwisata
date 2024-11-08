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
                            <th rowspan="2">Ubah</th>
                            <!-- Header Kelompok (Otomatis) -->
                            @foreach ($kelompok as $namaKelompok)
                                <th colspan="2">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                            @endforeach
                            @foreach ($wismannegara as $negara)
                                <th colspan="2">{{ $negara->wismannegara_name }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <!-- Sub-header Laki-laki dan Perempuan -->
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
                                    <a class="btn btn-xs btn-info" 
                                    href="{{ route('account.wisata.kunjunganwisata.edit', ['wisata_id' => $hash->encode($wisata->id),'tanggal_kunjungan' => $tanggal]) }}">Ubah </a>


                                </td>
                            
                                @foreach ($kelompok as $namaKelompok)
                                    <td>{{ $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_laki_laki') }}</td>
                                    <td>{{ $dataTanggal['kelompok']->where('kelompok_kunjungan_id', $namaKelompok->id)->sum('jumlah_perempuan') }}</td>
                                @endforeach
                                
                                <!-- Data Kunjungan per Negara -->
                    @foreach ($wismannegara as $negara)
                                    <td>{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') }}</td>
                                    <td>{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
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
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endsection
@endsection