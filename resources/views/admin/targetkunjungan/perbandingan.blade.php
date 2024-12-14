@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Form Filter Tahun -->
        <form method="GET" action="{{ route('admin.targetkunjungan.perbandingan') }}">
            <div class="row">
                <div class="col-lg-4">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun" class="form-control select2" style="width: 100%;">
                        @for ($year = 2022; $year <= 2025; $year++)
                            <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>  
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info">Terapkan Filter</button>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="card mt-4">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Target Kunjungan Wisata</th>
                        <th>Realisasi Kunjungan</th>
                        <th>Selisih</th>
                        <th>Persentase Selisih (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTarget = 0;
                        $totalRealisasi = 0;
                        $totalSelisih = 0;
                    @endphp
                    @foreach ($kunjungan as $item)
                        @php
                            $persentaseSelisih = $item['target'] > 0 ? (($item['realisasi'] - $item['target']) / $item['target']) * 100 : 0;
                            $totalTarget += $item['target'];
                            $totalRealisasi += $item['realisasi'];
                            $totalSelisih += $item['selisih'];
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::createFromFormat('m', $item['bulan'])->locale('id')->monthName }}</td>
                            <td>{{ number_format($item['target'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['realisasi'], 0, ',', '.') }}</td>
                            <td class="{{ $item['selisih'] < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($item['selisih'], 0, ',', '.') }}
                            </td>
                            <td>
                                {{ number_format($persentaseSelisih, 2, ',', '.') }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($totalTarget, 0, ',', '.') }}</th>
                        <th>{{ number_format($totalRealisasi, 0, ',', '.') }}</th>
                        <th class="{{ $totalSelisih < 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($totalSelisih, 0, ',', '.') }}
                        </th>
                        <th>
                            @php
                                $persentaseTotal = $totalTarget > 0 ? (($totalRealisasi - $totalTarget) / $totalTarget) * 100 : 0;
                            @endphp
                            {{ number_format($persentaseTotal, 2, ',', '.') }}%
                        </th>
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
<script>
    $(function () {
        $("#example1").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            ordering: false,
            paging: false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
