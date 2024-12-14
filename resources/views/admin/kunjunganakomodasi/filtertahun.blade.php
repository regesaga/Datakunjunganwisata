@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="card-header">
            <form action="{{ route('admin.kunjunganakomodasi.filtertahun') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="year" class="form-label">Tahun</label>
                        <select id="year" name="year" class="form-control select2" style="width: 100%;">
                            @for($y = date('Y'); $y >= 2023; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-info">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <h2>Laporan Kunjungan Wisatawan Tahun {{ $year }}</h2>
        
        <!-- Tabel Data Kunjungan Per Bulan -->
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Total Laki-Laki Domestik</th>
                            <th>Total Perempuan Domestik</th>
                            <th>Total Laki-Laki Mancanegara</th>
                            <th>Total Perempuan Mancanegara</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(range(1, 12) as $month)
                            <tr>
                                 <td style="text-align: center; text-transform: uppercase;">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</td>
                                 <td style="text-align: center; text-transform: uppercase;">{{ $kunjungan[$month]['total_laki_laki'] ?? 0 }}</td>
                                 <td style="text-align: center; text-transform: uppercase;">{{ $kunjungan[$month]['total_perempuan'] ?? 0 }}</td>
                                 <td style="text-align: center; text-transform: uppercase;">{{ $kunjungan[$month]['total_wisman_laki'] ?? 0 }}</td>
                                 <td style="text-align: center; text-transform: uppercase;">{{ $kunjungan[$month]['total_wisman_perempuan'] ?? 0 }}</td>
                                 <td style="text-align: center; text-transform: uppercase;">
                                    {{ ($kunjungan[$month]['total_laki_laki'] ?? 0) + 
                                       ($kunjungan[$month]['total_perempuan'] ?? 0) + 
                                       ($kunjungan[$month]['total_wisman_laki'] ?? 0) + 
                                       ($kunjungan[$month]['total_wisman_perempuan'] ?? 0) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total Keseluruhan</th>
                            <th>{{ $totalKeseluruhan['total_laki_laki'] }}</th>
                            <th>{{ $totalKeseluruhan['total_perempuan'] }}</th>
                            <th>{{ number_format($totalKeseluruhan['total_wisman_laki'], 0, ',', '.') }}
</th>
                            <th>{{ number_format($totalKeseluruhan['total_wisman_perempuan'], 0, ',', '.') }}
</th>
                            <th>
                                {{ $totalKeseluruhan['total_laki_laki'] + 
                                   $totalKeseluruhan['total_perempuan'] + 
                                   $totalKeseluruhan['total_wisman_laki'] + 
                                   $totalKeseluruhan['total_wisman_perempuan'] }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
