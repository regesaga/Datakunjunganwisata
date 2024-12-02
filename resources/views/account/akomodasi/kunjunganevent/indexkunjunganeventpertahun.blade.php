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
        <form method="GET" action="{{ route('account.akomodasi.kunjunganevent.indexkunjunganeventpertahun') }}">
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
                        <th colspan="{{ 4 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                            <h2 style="text-align: center; text-transform: uppercase;">
                                Rekap Data Kunjungan Event 
                            </h2>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: center; text-transform: uppercase;" rowspan="3">Aksi</th>
                        <th style="text-align: center; text-transform: uppercase;" rowspan="3">Nama Even</th>
                        <th style="text-align: center; text-transform: uppercase;" rowspan="3">Tanggal</th>
                        <th style="text-align: center; text-transform: uppercase;" rowspan="3">Total</th>
                        <th style="text-align: center; text-transform: uppercase;" colspan="{{ count($kelompok) * 2 }}" style="text-align: center;">Wisata Nusantara</th>
                        <th style="text-align: center; text-transform: uppercase;" colspan="{{ count($wismannegara) * 2 }}" style="text-align: center;">Wisata Mancanegara</th>
                    </tr>
                    <tr>
                        @foreach ($kelompok as $namaKelompok)
                            <th style="text-align: center; text-transform: uppercase;" colspan="2">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                            <th style="text-align: center; text-transform: uppercase;" colspan="2">{{ $negara->wismannegara_name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($kelompok as $namaKelompok)
                            <th style="text-align: center; text-transform: uppercase;">L</th>
                            <th style="text-align: center; text-transform: uppercase;">P</th>
                        @endforeach
                        @foreach ($wismannegara as $negara)
                            <th style="text-align: center; text-transform: uppercase;">L</th>
                            <th style="text-align: center; text-transform: uppercase;">P</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if ($events->isEmpty())
                        <tr>
                            <td colspan="{{ 4 + (count($kelompok) + count($wismannegara)) * 2 }}" style="text-align: center; text-transform: uppercase;">
                                Tidak ada kunjungan event yang diinput
                            </td>
                        </tr>
                    @else
                        @foreach ($events as $event)
                            @if (isset($kunjungan[$event->id]) && count($kunjungan[$event->id]) > 0)
                                @foreach ($kunjungan[$event->id] as $tanggal => $dataTanggal)
                                    <tr>
                                        <td style="text-align: center; text-transform: uppercase;">
                                            <a class="btn btn-info btn-sm" href="{{ route('account.akomodasi.kunjunganevent.edit', ['event_calendar_id' => $hash->encode($event->id), 'tanggal_kunjungan' => $tanggal]) }}">
                                                <i class="fas fa-pencil-alt"></i> Ubah
                                            </a>
                                            <a href="{{ route('account.akomodasi.kunjunganevent.delete', ['event_calendar_id' => $hash->encode($event->id), 'tanggal_kunjungan' => $tanggal]) }}" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data kunjungan tanggal {{ $tanggal }}?')) { document.getElementById('delete-form').submit(); }">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                            <form id="delete-form" action="{{ route('account.akomodasi.kunjunganevent.delete', ['event_calendar_id' => $hash->encode($event->id), 'tanggal_kunjungan' => $tanggal]) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                        <input type="hidden" id="event_calendar_id" value="{{ $hash->encode($event->id) }}">
                                        <td style="text-align: center; text-transform: uppercase;">{{ $event->title }}</td>
                                        <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                                        <input type="hidden" id="tanggal_kunjungan" value="{{ $tanggal }}">
                                        <td style="text-align: center; text-transform: uppercase;">
                                            @php
                                                $total = 0;
                                                foreach ($kelompok as $namaKelompok) {
                                                    $total += isset($dataTanggal['kelompok']) ? $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') : 0;
                                                    $total += isset($dataTanggal['kelompok']) ? $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') : 0;
                                                }
                                                foreach ($wismannegara as $negara) {
                                                    $total += isset($dataTanggal['wisman_by_negara']) ? $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') : 0;
                                                    $total += isset($dataTanggal['wisman_by_negara']) ? $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') : 0;
                                                }
                                            @endphp
                                            {{ $total }}
                                        </td>
                
                                        @foreach ($kelompok as $namaKelompok)
                                            <td style="text-align: center; text-transform: uppercase;">
                                                {{ isset($dataTanggal['kelompok']) ? $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') : 0 }}
                                            </td>
                                            <td style="text-align: center; text-transform: uppercase;">
                                                {{ isset($dataTanggal['kelompok']) ? $dataTanggal['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') : 0 }}
                                            </td>
                                        @endforeach
                
                                        @foreach ($wismannegara as $negara)
                                            <td style="text-align: center; text-transform: uppercase;">
                                                {{ isset($dataTanggal['wisman_by_negara']) ? $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_laki') : 0 }}
                                            </td>
                                            <td style="text-align: center; text-transform: uppercase;">
                                                {{ isset($dataTanggal['wisman_by_negara']) ? $dataTanggal['wisman_by_negara']->get($negara->id, collect())->sum('jml_wisman_perempuan') : 0 }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="{{ 4 + (count($kelompok) + count($wismannegara)) * 2 }}" style="text-align: center; text-transform: uppercase;">
                                        Tidak ada kunjungan untuk event: {{ $event->title }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
                
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: center; text-transform: uppercase;">Total Keseluruhan</th>
                        <th style="text-align: center; text-transform: uppercase;">
                            {{ collect($kunjungan)->flatMap(function($eventData) {
                                return collect($eventData)->flatMap(function($tanggalData) {
                                    return [$tanggalData];
                                });
                            })->sum(function($dataTanggal) use ($kelompok, $wismannegara) {
                                $total = 0;
                                // Total untuk kelompok kunjungan
                                foreach ($kelompok as $kelompokItem) {
                                    $total += collect($dataTanggal['kelompok'] ?? [])->get($kelompokItem->id, collect())->sum('jumlah_laki_laki');
                                    $total += collect($dataTanggal['kelompok'] ?? [])->get($kelompokItem->id, collect())->sum('jumlah_perempuan');
                                }
                                // Total untuk wismannegara
                                foreach ($wismannegara as $negara) {
                                    $total += collect($dataTanggal['wisman_by_negara'] ?? [])->get($negara->id, collect())->sum('jml_wisman_laki');
                                    $total += collect($dataTanggal['wisman_by_negara'] ?? [])->get($negara->id, collect())->sum('jml_wisman_perempuan');
                                }
                                return $total;
                            }) }}
                        </th>
                        @foreach ($kelompok as $kelompokItem)
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->flatMap(function($eventData) {
                                    return collect($eventData)->flatMap(function($tanggalData) {
                                        return [$tanggalData];
                                    });
                                })->sum(function($dataTanggal) use ($kelompokItem) {
                                    return collect($dataTanggal['kelompok'] ?? [])->get($kelompokItem->id, collect())->sum('jumlah_laki_laki');
                                }) }}
                            </th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->flatMap(function($eventData) {
                                    return collect($eventData)->flatMap(function($tanggalData) {
                                        return [$tanggalData];
                                    });
                                })->sum(function($dataTanggal) use ($kelompokItem) {
                                    return collect($dataTanggal['kelompok'] ?? [])->get($kelompokItem->id, collect())->sum('jumlah_perempuan');
                                }) }}
                            </th>
                        @endforeach
                
                        @foreach ($wismannegara as $negara)
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->flatMap(function($eventData) {
                                    return collect($eventData)->flatMap(function($tanggalData) {
                                        return [$tanggalData];
                                    });
                                })->sum(function($dataTanggal) use ($negara) {
                                    return collect($dataTanggal['wisman_by_negara'] ?? [])->get($negara->id, collect())->sum('jml_wisman_laki');
                                }) }}
                            </th>
                            <th style="text-align: center; text-transform: uppercase;">
                                {{ collect($kunjungan)->flatMap(function($eventData) {
                                    return collect($eventData)->flatMap(function($tanggalData) {
                                        return [$tanggalData];
                                    });
                                })->sum(function($dataTanggal) use ($negara) {
                                    return collect($dataTanggal['wisman_by_negara'] ?? [])->get($negara->id, collect())->sum('jml_wisman_perempuan');
                                }) }}
                            </th>
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
<script src="{{ asset('datakunjungan/plugins/pdfmake/vfs_fonts.js')}}"></script>

@endsection