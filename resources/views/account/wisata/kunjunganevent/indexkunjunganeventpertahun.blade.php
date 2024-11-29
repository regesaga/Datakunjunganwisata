@extends('layouts.datakunjungan.datakunjungan')

<style>
    .editable input:focus {
        background-color: #e0f7fa; /* Warna biru muda saat input difokuskan */
        border-color: #008cba; /* Warna border saat difokuskan */
    }

    .editing {
        background-color: #fff3e0; /* Warna latar belakang saat sedang diedit */
    }

    .saved {
        background-color: #c8e6c9; /* Warna latar belakang setelah disimpan */
    }

    .blurred {
        filter: blur(2px); /* Efek blur untuk baris yang tidak sedang diedit */
        pointer-events: none; /* Menonaktifkan interaksi dengan elemen yang diburamkan */
    }
</style>

@section('content')

<section class="content-header">

    <div class="container-fluid">

        <!-- Form Filter Bulan dan Tahun -->
        <form method="GET" action="{{ route('account.wisata.kunjunganevent.indexkunjunganeventpertahun') }}">
            <div class="row">
                <div class="col-lg-4">
                    <label  style="text-align: center; text-transform: uppercase;" for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun" class="form-control select2" style="width: 100%;">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
               
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info">Terapkan Filter</button>
                </div>
            </div>
        </form>

        <div class="card">

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                            <h2 style="text-align: center; text-transform: uppercase;">
                                Rekap Data Kunjungan Event 
                            </h2>
                        </th>
                    </tr>
                    <tr>
                        <th  style="text-align: center; text-transform: uppercase;"rowspan="3">Aksi</th>
                        <th  style="text-align: center; text-transform: uppercase;"rowspan="3">Nama Even</th>
                        <th  style="text-align: center; text-transform: uppercase;"rowspan="3">Tanggal</th>
                        <th  style="text-align: center; text-transform: uppercase;"rowspan="3">Total</th>
                        <th  style="text-align: center; text-transform: uppercase;"colspan="{{ count($kelompok) * 2 }}" style="text-align: center;">Wisata Nusantara</th>
                        <th  style="text-align: center; text-transform: uppercase;"colspan="{{ count($wismannegara) * 2 }}" style="text-align: center;">Wisata Mancanegara</th>
                    </tr>
                    <tr>
                        @foreach ($kelompok as $namaKelompok)
                            <th  style="text-align: center; text-transform: uppercase;"colspan="2">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                            <th  style="text-align: center; text-transform: uppercase;"colspan="2">{{ $negara->wismannegara_name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($kelompok as $namaKelompok)
                            <th  style="text-align: center; text-transform: uppercase;">L</th>
                            <th  style="text-align: center; text-transform: uppercase;">P</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                            <th  style="text-align: center; text-transform: uppercase;">L</th>
                            <th  style="text-align: center; text-transform: uppercase;">P</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungan as $tanggal => $dataTanggal)
                                       
                        <tr>
                            <td>
                                <div style="text-align: center;">
                                    <button  style="text-align: center; text-transform: uppercase;"id="btn-save" class="btn btn-outline-success btn-sm">Simpan</button>
                                </div>
                            </td>
                            <input type="hidden" id="event_calendar_id" value="{{ $hash->encode($events->id) }}">
                            <td  style="text-align: center; text-transform: uppercase;">{{$events->title }}</td>
                            <td  style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>

                            <input type="hidden" id="tanggal_kunjungan" value="{{ $tanggal }}">
                            <td  style="text-align: center; text-transform: uppercase;">
                                {{ $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'] }}
                            </td>
                            @foreach ($kelompok as $namaKelompok)
                            <td class="editable" data-field="jumlah_laki_laki{{ $namaKelompok->id }}" data-tanggal="{{ $tanggal }}" data-kelompok="{{ $namaKelompok->id }}">
                                <input type="text" min="0" step="1" value="{{ $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') }}" class="form-control edit-field" style="width: 60px;" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </td>
                            <td class="editable" data-field="jumlah_perempuan{{ $namaKelompok->id }}" data-tanggal="{{ $tanggal }}" data-kelompok="{{ $namaKelompok->id }}">
                                <input type="text" min="0" step="1" value="{{ $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') }}" class="form-control edit-field" style="width: 60px;" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </td>
                            @endforeach
                            
                            @foreach ($wismannegara as $negara)
                            <td class="editable" data-field="jml_wisman_laki{{ $negara->id }}" data-tanggal="{{ $tanggal }}" data-negara="{{ $negara->id }}">
                                <input type="text" min="0" step="1" value="{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') }}" class="form-control edit-field" style="width: 60px;" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </td>
                            <td class="editable" data-field="jml_wisman_perempuan{{ $negara->id }}" data-tanggal="{{ $tanggal }}" data-negara="{{ $negara->id }}">
                                <input type="text" min="0" step="1" value="{{ $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') }}" class="form-control edit-field" style="width: 60px;" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: center; text-transform: uppercase;">Total Keseluruhan</th>
                       
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->sum(function($dataTanggal) {
                                return $dataTanggal['jumlah_laki_laki'] + $dataTanggal['jumlah_perempuan'] + $dataTanggal['jml_wisman_laki'] + $dataTanggal['jml_wisman_perempuan'];
                            }) }}
                        </th>
                        @foreach ($kelompok as $namaKelompok)
                            <th  style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataTanggal) use ($namaKelompok) {
                                return $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki');
                            }) }}</th>
                            <th  style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataTanggal) use ($namaKelompok) {
                                return $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan');
                            }) }}</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                        <th  style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataTanggal) use ($negara) {
                            return $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki');
                        }) }}</th>
                        <th  style="text-align: center; text-transform: uppercase;">{{ collect($kunjungan)->sum(function($dataTanggal) use ($negara) {
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
<script>
    $(document).on('focus', '.editable input', function() {
        var row = $(this).closest('tr');
        // Blur other rows
        $('tbody tr').not(row).addClass('blurred');
    });

    $(document).on('blur', '.editable input', function() {
        // Remove blur effect when input loses focus
        $('tbody tr').removeClass('blurred');
    });

    $(document).on('click', '#btn-save', function() {
        var row = $(this).closest('tr');
        var event_calendar_id = $('#event_calendar_id').val();
        var tanggal_kunjungan = row.find('input[id="tanggal_kunjungan"]').val();

        var jumlah_laki_laki = {};
        var jumlah_perempuan = {};
        var jml_wisman_laki = {};
        var jml_wisman_perempuan = {};

        row.find('.editable[data-kelompok]').each(function() {
            var kelompok = $(this).data('kelompok');
            var field = $(this).data('field');
            var inputValue = $(this).find('input').val();

            if (inputValue !== '') {
                if (field.startsWith('jumlah_laki_laki')) {
                    jumlah_laki_laki[kelompok] = parseInt(inputValue) || 0;
                } else if (field.startsWith('jumlah_perempuan')) {
                    jumlah_perempuan[kelompok] = parseInt(inputValue) || 0;
                }
            }
        });

        row.find('.editable[data-negara]').each(function() {
            var negara = $( this).data('negara');
            var field = $(this).data('field');
            var inputValue = $(this).find('input').val();

            if (inputValue !== '') {
                if (field.startsWith('jml_wisman_laki')) {
                    jml_wisman_laki[negara] = parseInt(inputValue) || 0;
                } else if (field.startsWith('jml_wisman_perempuan')) {
                    jml_wisman_perempuan[negara] = parseInt(inputValue) || 0;
                }
            }
        });

        $.ajax({
            url: '{{ route("account.wisata.kunjunganevent.storewisnuindexeven") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                event_calendar_id: event_calendar_id,
                tanggal_kunjungan: tanggal_kunjungan,
                jumlah_laki_laki: jumlah_laki_laki,
                jumlah_perempuan: jumlah_perempuan,
                jml_wisman_laki: jml_wisman_laki,
                jml_wisman_perempuan: jml_wisman_perempuan
            },
            success: function(response) {
                if (response.success) {
                    alert('Data berhasil disimpan!');
                    // Remove blur effect after saving
                    $('tbody tr').removeClass('blurred');
                } else {
                    alert('Terjadi kesalahan!');
                }
            },
            error: function() {
                alert('Terjadi kesalahan!');
            }
        });
    });
</script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('datakunjungan/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/pdfmake/vfs_fonts.js')}}"></script>

@endsection