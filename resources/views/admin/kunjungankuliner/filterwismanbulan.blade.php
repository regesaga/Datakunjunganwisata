@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h2 style="text-align: center; text-transform: uppercase;">Laporan Kunjungan Wisatawan Mancanegara</h2>

        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('admin.kunjungankuliner.filterwismanbulan') }}">
            <div class="row">
                <div class="col-lg-4">
                    <label style="text-align: center; text-transform: uppercase;" for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun"  class="form-control select2" style="width: 100%;">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-4">
                    <label style="text-align: center; text-transform: uppercase;" for="bulan" class="form-label">Bulan</label>
                    <select id="bulan" name="bulan"  class="form-control select2" style="width: 100%;">
                        @foreach(range(1, 12) as $m)
                            <option style="text-align: center; text-transform: uppercase;" value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
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
                <a style="text-align: center; text-transform: uppercase;" class="btn btn-outline-success btn-sm" href="{{ route("admin.kunjungankuliner.createwisnu") }}">
                    Tambah Data
                </a>
            </div>

            <table id="example1" class="table table-bordered table-striped">
                <th style="text-align: center; text-transform: uppercase;"ead>
                    <tr>
                        <th style="text-align: center; text-transform: uppercase;" style="text-align: center; text-transform: uppercase;" rowspan="2">Tanggal</th>
                        <th style="text-align: center; text-transform: uppercase;" style="text-align: center; text-transform: uppercase;" rowspan="2">Total</th>
                        <th style="text-align: center; text-transform: uppercase;" style="text-align: center; text-transform: uppercase;" rowspan="2">Aksi</th>
                      
                        @foreach ($wismannegara as $negara)
                            <th style="text-align: center; text-transform: uppercase;" colspan="2">{{ $negara->wismannegara_name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                      
                        @foreach ($wismannegara as $negara)
                            <th style="text-align: center; text-transform: uppercase;">L</th>
                            <th style="text-align: center; text-transform: uppercase;">P</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungan as $tanggal => $dataTanggal)
                        <tr>
                            <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>

                            <td>
                                {{ $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                            </td>
                            <td>
                                <a style="text-align: center; text-transform: uppercase;" class="btn btn-info btn-sm" href="{{ route('admin.kunjungankuliner.edit', ['kuliner_id' => $hash->encode($kuliner->id),'tanggal_kunjungan' => $tanggal]) }}">
                                    <i class="fas fa-pencil-alt"></i> Ubah
                                </a>
                                <a style="text-align: center; text-transform: uppercase;" href="{{ route('admin.kunjungankuliner.delete', ['kuliner_id' => $hash->encode($kuliner->id), 'tanggal_kunjungan' => $tanggal]) }}"
                                    class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data kunjungan tanggal {{ $tanggal }}?')) { document.getElementById('delete-form').submit(); }">
                                     <i class="fas fa-trash"></i> Hapus
                                 </a>
                                 
                                 <form id="delete-form" action="{{ route('admin.kunjungankuliner.delete', ['kuliner_id' => $hash->encode($kuliner->id), 'tanggal_kunjungan' => $tanggal]) }}" method="POST" style="display:none;">
                                     @csrf
                                     @method('DELETE')
                                 </form>
                            </td>

                           

                            @foreach ($wismannegara as $negara)
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') }}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th style="text-align: center; text-transform: uppercase;">Total Keseluruhan</th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ $kunjungan->sum(function($dataTanggal) {
                                return $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'];
                            }) }}
                        </th>
                        <th style="text-align: center; text-transform: uppercase;"></th>

                      

                        @foreach ($wismannegara as $negara)
                            <th style="text-align: center; text-transform: uppercase;">{{ $kunjungan->sum(function($dataTanggal) use ($negara) {
                                return $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                            }) }}</th>
                            <th style="text-align: center; text-transform: uppercase;">{{ $kunjungan->sum(function($dataTanggal) use ($negara) {
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
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection