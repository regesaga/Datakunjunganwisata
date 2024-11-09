@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h2>Laporan Kunjungan Wisatawan</h2>

        <!-- Filter Form -->
        <div class="card">
            <div class="card-header">
                <form action="{{ route('account.wisata.kunjunganwisata.filterbulan') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="year" class="form-label">Tahun</label>
                            <select id="year" name="year"  class="form-control select2" style="width: 100%;">
                                @for($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="month" class="form-label">Bulan</label>
                            <select id="month" name="month"  class="form-control select2" style="width: 100%;">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
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
            </div>

            <!-- Tabel Data Kunjungan -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total Laki-Laki</th>
                            <th>Total Perempuan</th>
                            <th>Total Wisman Laki-Laki</th>
                            <th>Total Wisman Perempuan</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungan as $tanggal => $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</td>
                                <td>{{ $data['jumlah_laki_laki'] }}</td>
                                <td>{{ $data['jumlah_perempuan'] }}</td>
                                <td>{{ $data['jml_wisman_laki'] }}</td>
                                <td>{{ $data['jml_wisman_perempuan'] }}</td>
                                <td>{{ $data['jumlah_laki_laki'] + $data['jumlah_perempuan'] + $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="fst-italic text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <!-- TFOOT untuk menampilkan total keseluruhan -->
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>{{ $kunjungan->sum('jumlah_laki_laki') }}</th>
                            <th>{{ $kunjungan->sum('jumlah_perempuan') }}</th>
                            <th>{{ $kunjungan->sum('jml_wisman_laki') }}</th>
                            <th>{{ $kunjungan->sum('jml_wisman_perempuan') }}</th>
                            <th>
                                {{ $kunjungan->sum(function($data) {
                                    return $data['jumlah_laki_laki'] + $data['jumlah_perempuan'] + $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'];
                                }) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
