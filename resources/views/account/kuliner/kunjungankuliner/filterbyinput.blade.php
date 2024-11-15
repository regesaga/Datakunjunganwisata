@extends('layouts.datakunjungan.datakunjungan')

@section('styles')
<!-- FullCalendar CSS -->
<link href="{{ asset('datakunjungan/plugins/fullcalendar/main.css') }}" rel="stylesheet">

<style>
    /* FullCalendar Styling */
    #calendar {
        width: 100%;
        margin: 20px 0;
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 10px;
    }

    /* Responsif untuk perangkat mobile */
    @media (max-width: 768px) {
        #calendar {
            font-size: 12px;  /* Ukuran font lebih kecil di perangkat mobile */
            padding: 5px;
        }
    }

    /* Menambahkan ukuran lebih kecil untuk tampilan desktop */
    @media (min-width: 992px) {
        #calendar {
            font-size: 14px; /* Ukuran font sedikit lebih besar untuk desktop */
        }
    }

    /* Styling form-container dan elemen lainnya */
    .form-container {
        max-width: 1000px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .form-header h3 {
        font-size: 16px;
        color: darkgrey;
        margin: 0;
    }
    .form-header h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }
    .form-date {
        margin-right: 15px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .btn-save {
        background-color: #8e44ad;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div id="calendar"></div>
        <form action="{{ route('account.kuliner.kunjungankuliner.storewisnu') }}" method="POST">
            @csrf
            <div class="form-header">
                <h3>Tambah Laporan Kunjungan</h3>
                <h2>{{$kuliner->namakuliner}}</h2>
                <div class="form-date">
                    <label for="tanggal">Tanggal:</label>
                    <input type="date" name="tanggal_kunjungan" class="form-control">
                </div>
                <button type="submit" class="btn-save">Simpan Data</button>
            </div>
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }} 
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-lg-12">
                <input type="hidden" name="kuliner_id" value="{{ $kuliner->id }}">
                <div class="visitor-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="visitor-card">
                                <strong>Kunjungan Wisatawan Nusantara (WISNU)</strong>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Pengunjung</th>
                                            <th>Laki-laki</th>
                                            <th>Perempuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelompok as $namaKelompok)
                                        <tr>
                                            <td>{{ $namaKelompok->kelompokkunjungan_name }}</td>
                                            <td>
                                                <input type="number" id="jumlah_laki_laki_{{ $namaKelompok->id }}" name="jumlah_laki_laki[{{ $namaKelompok->id }}]" class="form-control"  value="0"  oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')" oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                            </td>
                                            <td>
                                                <input type="number" id="jumlah_perempuan_{{ $namaKelompok->id }}" name="jumlah_perempuan[{{ $namaKelompok->id }}]" class="form-control"  value="0" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')" oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td>
                                                <input type="text" id="total_wisnu_laki" name="total_wisnu_laki" class="form-control" value="0" readonly>
                                            </td>
                                            <td>
                                                <input type="text" id="total_wisnu_perempuan" name="total_wisnu_perempuan" class="form-control"   value="0" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td colspan="2"> 
                                                <input type="text" id="total_wisnu" name="total_wisnu" class="form-control" value="0" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="visitor-card">
                                <strong>Kunjungan Wisatawan Mancanegara (WISMAN)</strong>
                                <table class="table table-bordered" id="wisman-table">
                                    <thead>
                                        <tr>
                                            <th>Negara</th>
                                            <th>Laki-laki</th>
                                            <th>Perempuan</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <button type="button" class="btn btn-primary" id="add-row">Tambah</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td><input type="text" name="jml_wismanlakilaki" id="jml_wismanlakilaki" class="form-control" value="0" readonly></td>
                                            <td><input type="text" name="jml_wismanperempuan" id="jml_wismanperempuan" class="form-control" value="0" readonly></td>
                                            <td><input type="text" name="total_wisman" id="total_wisman" class="form-control" value="0" readonly></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<!-- FullCalendar JS -->
<script src="{{ asset('datakunjungan/plugins/fullcalendar/main.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',  // Tampilan kalender bulanan
            headerToolbar: {
                left: 'prev,next today',     // Tombol untuk navigasi bulan
                center: 'title',             // Judul bulan
                right: 'dayGridMonth,timeGridWeek,timeGridDay'  // Pilihan tampilan kalender
            },
            events: [
                { title: 'All Day Event', start: '2024-11-01', backgroundColor: '#f56954', borderColor: '#f56954', allDay: true },
                { title: 'Meeting', start: '2024-11-03T10:30:00', backgroundColor: '#0073b7', borderColor: '#0073b7', allDay: false },
                { title: 'Lunch', start: '2024-11-05T12:00:00', end: '2024-11-05T14:00:00', backgroundColor: '#00c0ef', borderColor: '#00c0ef', allDay: false }
            ],
            editable: true,
            droppable: true
        });
        calendar.render();
    });
</script>
@endsection
