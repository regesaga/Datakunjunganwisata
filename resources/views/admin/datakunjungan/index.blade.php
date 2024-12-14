@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <!-- Tabel Data Kunjungan Per Bulan -->
        <div class="card-body">
                <div class="row">
                    <div class="col">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $jumlah_userwisata }}</h3>
                                    <p>Operator wisata</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                            </div>
                    </div>
                    <div class="col">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $jumlah_userkuliner }}</h3>
                                    <p>Operator Kuliner</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                            </div>
                    </div>
                    <div class="col">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $jumlah_userakomodasi}}</h3>
                                    <p>Operator Akomodasi</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
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
                <figure class="highcharts-figure">
                    <div id="Totalkunjungan"></div>
    
                </figure>


                <div id="chart"></div>
                 <!-- Donut Chart -->
            <div class="row">
                <div class="col">
                    <div id="donut-chart"></div>
                </div>
            </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
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
                    <div class="col-lg-3 col-6">
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
                    <div class="col-lg-3 col-6">
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
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhan['totalkunjunganEvent']}}</h3>
                                <p>Pengunjung Even</p>
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
                
                
                    <div class="row">
                        <div class="col">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3> {{ 
                                        $totalKeseluruhan['total_wisman_laki'] + 
                                        $totalKeseluruhan['total_wisman_perempuan'] }}</h3>
                        
                                    <p>Jumlah Pengunjung Mancanegara</p>
                                </div>
                                <div class="icon">
                                <i class="ion ion-person-add"></i>
                                </div>

                                <table id="example1" class="table table-striped">
                                    @foreach ($negaraData as $data)
                                    <tr>
                                         <td style="text-align: center; text-transform: uppercase;"> {{$data['name'] }}</td>
                                        <td >{{ ($data['jml_wisman_laki'] ?? 0) + ($data['jml_wisman_perempuan'] ?? 0) }}</td>
                                    </tr>
                                @endforeach
                        
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <div id="chartbar"></div>
            </div>
           
        </div>

           </div>
</section>
@section('scripts')
<!-- DataTables  & Plugins -->

@section('scripts')
<!-- Highcharts JS -->
<script src="{{ asset('datakunjungan/Highcharts.js') }}"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    // Mengambil data dari controller
    const semuakunjungan = @json($semuakunjungan);

    // Ekstrak data bulan, target, dan realisasi dari data yang dikirim
    const bulan = semuakunjungan.map(item => item.bulan);
    const target = semuakunjungan.map(item => item.target);
    const realisasi = semuakunjungan.map(item => item.realisasi);

    // Daftar nama bulan
    const bulanNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // Membuat array bulan dengan nilai dari 1 hingga 12
    const allBulan = bulanNames.slice(0, 12);

    // Mengisi data target dan realisasi sesuai dengan bulan yang tersedia
    const targetKunjungan = new Array(12).fill(0); // Inisialisasi dengan 0
    const realisasiKunjungan = new Array(12).fill(0); // Inisialisasi dengan 0

    // Menyesuaikan target dan realisasi berdasarkan bulan
    bulan.forEach((b, index) => {
        const bulanIndex = b - 1; // Sesuaikan dengan index bulan (bulan 1 = index 0)
        targetKunjungan[bulanIndex] = target[index]; 
        realisasiKunjungan[bulanIndex] = realisasi[index];
    });

    // Membuat chart dengan Highcharts
    Highcharts.chart('Totalkunjungan', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Trends Kunjungan'
        },
        subtitle: {
            text: 'Data Kunjungan dari Hasil Input'
        },
        xAxis: {
            categories: allBulan, // Menampilkan bulan dari Januari sampai Desember
        },
        yAxis: {
            title: {
                text: 'Jumlah Kunjungan'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Target Kunjungan',
            data: targetKunjungan // Menampilkan data target
        }, {
            name: 'Realisasi Kunjungan',
            data: realisasiKunjungan // Menampilkan data realisasi
        }]
    });
</script>

@endsection

@endsection

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        series: [{
            data: [
                @foreach($negaraData as $data)
                    {{ $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'] }},
                @endforeach
            ]
        }],
        chart: {
            type: 'bar',
            height: 150
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                distributed: true,
                horizontal: true,
                dataLabels: {
                    position: 'bottom'
                }
            }
        },
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
            '#f48024', '#69d2e7'
        ],
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#fff']
            },
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
            },
            offsetX: 0,
            dropShadow: {
                enabled: true
            }
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        xaxis: {
            categories: [
                @foreach($negaraData as $data)
                    '{{ $data['name'] }}',
                @endforeach
            ],
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        title: {
            align: 'center',
            floating: true
        },
        subtitle: {
            align: 'center',
        },
        tooltip: {
            theme: 'dark',
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function () {
                        return ''
                    }
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartbar"), options);
    chart.render();
</script>
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
        }, {
            name: 'Event',
            data: @json($totalEventAll)  // Data total perempuan
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




<script>
    var options = {
        series: [
            {{ $totalKeseluruhan['totalkunjunganWisata'] }},
            {{ $totalKeseluruhan['totalkunjunganKuliner'] }},
            {{ $totalKeseluruhan['totalkunjunganAkomodasi'] }},
            {{ $totalKeseluruhan['totalkunjunganEvent'] }}
        ],
        chart: {
            width: 380,
            type: 'donut',
        },
        labels: [
            "Wisata",
            "Kuliner",
            "Akomodasi",
            "Even"
        ],
        plotOptions: {
            pie: {
                startAngle: -90,
                endAngle: 270
            }
        },
        dataLabels: {
            enabled: false
        },
        fill: {
            type: 'gradient',
        },
        legend: {
            formatter: function(val, opts) {
                return val + " - " + opts.w.globals.series[opts.seriesIndex];
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#donut-chart"), options);
    chart.render();
</script>

@endsection
