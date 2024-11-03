@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<div class="container">
    <h2>Laporan Kunjungan Wisatawan</h2>

    <!-- Filter Form -->
    <form action="{{ route('account.wisata.kunjunganwisata.filterbulan') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="year" class="form-label">Tahun</label>
                <select id="year" name="year" class="form-select">
                    @for($y = date('Y'); $y >= 2000; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="month" class="form-label">Bulan</label>
                <select id="month" name="month" class="form-select">
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

    <!-- Tabel Data Kunjungan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total Laki-Laki</th>
                <th>Total Perempuan</th>
                <th>Total Wisman Laki-Laki</th>
                <th>Total Wisman Perempuan</th>
                <th>Sub Total</th>
                <!-- Kolom lainnya sesuai kebutuhan -->
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
                    <!-- Data lainnya -->
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="fst-italic text-center">Tidak Ada Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
