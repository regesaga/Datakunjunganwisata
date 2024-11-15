@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h2>Laporan Kunjungan Wisatawan Mancanegara</h2>
        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('admin.kelompokkunjungan.kunjunganakomodasi.filterwismanbulan') }}">
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
                <a class="btn btn-success" href="{{ route("admin.kelompokkunjungan.kunjunganakomodasi.createwisnu") }}">
                    Tambah Data
                </a>
            </div>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">Total</th>
                        <th rowspan="2">Aksi</th>
                      
                        @foreach ($wismannegara as $negara)
                            <th colspan="2">{{ $negara->wismannegara_name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                      
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
                                {{ $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('admin.kelompokkunjungan.kunjunganakomodasi.edit', ['wisata_id' => $hash->encode($wisata->id),'tanggal_kunjungan' => $tanggal]) }}">
                                    <i class="fas fa-pencil-alt"></i> Ubah
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
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
                        <th></th>

                      

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
@endsection
@endsection

