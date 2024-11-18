@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Tabel Data Kunjungan Per Bulan -->
        <div class="card">
            <div class="card-header">
                <form action="{{ route('admin.datakunjungan.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-lg-2">
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
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Kunjungan Wisatawan Tahun {{ $year }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                        <i class="far fa-calendar-alt"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['total_wisman_laki'] + $totalKeseluruhan['total_laki_laki'] }}</h3>
                                <p>Pengunjung Laki Laki</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-male"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['total_laki_laki'] + 
                                    $totalKeseluruhan['total_perempuan'] + 
                                    $totalKeseluruhan['total_wisman_laki'] + 
                                    $totalKeseluruhan['total_wisman_perempuan'] }}</h3>
                                <p>Total Pengunjung</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-woman"> <i class="ion ion-man"> </i></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['total_wisman_perempuan'] + $totalKeseluruhan['total_perempuan'] }}</h3>
                                <p>Pengunjung Perempuan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-female"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chart"></div>
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['totalkunjunganKuliner'] }}</h3>
                                <p>Pengunjung Kuliner</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-male"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['totalkunjunganWisata']}}</h3>
                                <p>Pengunjung Wisata</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-woman"> <i class="ion ion-man"> </i></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['totalkunjunganAkomodasi']}}</h3>
                                <p>Pengunjung Akomodasi</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-female"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chartkunjungan"></div>

                <div class="row">
                    <div class="col">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['total_laki_laki'] + $totalKeseluruhan['total_perempuan'] }}</h3>
                                <p>Jumlah Pengunjung Nusantara</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($kelompokData as $data)
                        <div class="col">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ ($data['jumlah_laki_laki'] ?? 0) + ($data['jumlah_perempuan'] ?? 0) }}</h3> <!-- Total jumlah -->
                                    <p>{{$data['name'] }}</p> <!-- Nama kelompok jika ada -->
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Donut Chart -->
                    <div class="row">
                        <div class="col">
                            <div id="donut-chart"></div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['total_wisman_laki'] + $totalKeseluruhan['total_wisman_perempuan'] }}</h3>
                                <p>Jumlah Pengunjung Mancanegara</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="row">
                    @foreach ($kelompok as $namaKelompok)
    <div class="col-4 text-center">
        <div id="sparkline-1">
            {{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                if (isset($dataBulan->kelompok) && $dataBulan->kelompok->has($namaKelompok->id)) {
                    return $dataBulan->kelompok->get($namaKelompok->id)->sum(function($item) {
                        return $item->jumlah_laki_laki + $item->jumlah_perempuan;
                    });
                }
                return 0;
            }) }}
        </div>
        <div class="text-white">{{ $namaKelompok->kelompokkunjungan_name }}</div>
    </div>
@endforeach

                </div>
            </div>
        </div>

           </div>
</section>
@section('scripts')
<!-- DataTables  & Plugins -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    var options = {
        series: [{
            name: 'Wisata',
            data: @json($totalWisataAll)  // Data total 
        }, {
            name: 'Kuliner',
            data: @json($totalKulinerAll)  // Data total laki-laki
        }, {
            name: 'Akomodasi',
            data: @json($totalAkomodasiAll)  // Data total perempuan
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($bulan),  // Menggunakan nama bulan untuk kategori
        },
        yaxis: {
            title: {
                text: 'Jumlah Kunjungan'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartkunjungan"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [{
            name: 'Laki-Laki',
            data: @json($totalKunjunganLaki)  // Data total kunjungan
        }, {
            name: 'Total Kunjungan',
            data: @json($totalKunjungan)  // Data total laki-laki
        }, {
            name: 'Perempuan',
            data: @json($totalKunjunganPerempuan)  // Data total perempuan
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($bulan),  // Menggunakan nama bulan untuk kategori
        },
        yaxis: {
            title: {
                text: 'Jumlah Kunjungan'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>



@endsection
@endsection
