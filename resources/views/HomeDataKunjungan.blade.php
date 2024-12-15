@extends('layouts.datakunjungan.Homedatakunjungan')

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
                    <div class="card-header">
                        <form action="{{ route('HomeDataKunjungan') }}" method="GET" class="mb-4">
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
            
                    <div class="card" id="card1">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                Kunjungan Wisatawan Tahun {{ $year }}
                            </h3>
                            <div class="card-tools">
                                
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
                                            <h3>{{ number_format($totalKeseluruhan['total_wisman_laki'] + $totalKeseluruhan['total_laki_laki'], 0, ',', '.') }}</h3>
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
                                            <h3>{{ number_format($totalKeseluruhan['total_laki_laki'] + $totalKeseluruhan['total_perempuan'] + $totalKeseluruhan['total_wisman_laki'] + $totalKeseluruhan['total_wisman_perempuan'], 0, ',', '.') }}</h3>
                                            <p>Total Pengunjung</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars">  </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ number_format($totalKeseluruhan['total_wisman_perempuan'] + $totalKeseluruhan['total_perempuan'], 0, ',', '.') }}</h3>
                                            <p>Pengunjung Perempuan</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-female"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div id="Totalkunjungan"></div>
                
                            <!-- Donut Chart -->
                            <div class="row">
                                <div class="col">
                                    <div id="donut-chart"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ number_format($totalKeseluruhan['totalkunjunganKuliner'], 0, ',', '.') }}</h3>
                                            <p>Pengunjung Kuliner</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-coffee"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3>{{ number_format($totalKeseluruhan['totalkunjunganWisata'], 0, ',', '.') }}</h3>
                                            <p>Pengunjung Wisata</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-image"> </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ number_format($totalKeseluruhan['totalkunjunganAkomodasi'], 0, ',', '.') }}</h3>
                                            <p>Pengunjung Akomodasi</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-home"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ number_format($totalKeseluruhan['totalkunjunganEvent'], 0, ',', '.') }}</h3>
                                            <p>Pengunjung Even</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-easel"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="chart"></div>
                                </div>
                                <div class="col">
                                    <div id="chartkunjungan"></div>

                                </div>
                            </div>
                          
                        </div>
                </div>

                <div class="card" id="card2">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-1"></i>
                            Kunjungan Terbanyak {{ $year }}
                        </h3>
                        <div class="card-tools">
                            
                            <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse" title="Collapse1">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                        <div class="card-body">
                        
                          
                            <div class="row">
                                <div class="col">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ number_format($totalKeseluruhan['total_laki_laki'] + $totalKeseluruhan['total_perempuan'], 0, ',', '.') }}</h3>
                                            <p>Jumlah Pengunjung Nusantara</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-pie-graph"></i>
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
                                                <h3>{{ number_format(($data['jumlah_laki_laki'] ?? 0) + ($data['jumlah_perempuan'] ?? 0), 0, ',', '.') }}</h3> <!-- Total jumlah -->
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
                                                <h3> {{ number_format($totalKeseluruhan['total_wisman_laki'] + $totalKeseluruhan['total_wisman_perempuan'], 0, ',', '.') }}</h3>
                                    
                                                <p>Jumlah Pengunjung Mancanegara</p>
                                            </div>
                                            <div class="icon">
                                            <i class="ion ion-earth"></i>
                                            </div>
                                        </div>

                                        <div id="chartbar"></div>
                                    </div>
                                </div>
                </div>
            </div>

</section>
<!-- DataTables  & Plugins -->

@section('scripts')
<!-- Highcharts JS -->
<script src="{{ asset('datakunjungan/Highcharts.js') }}"></script>

<script>
    // Mengambil data dari controller
    const semuakunjungan = @json($semuakunjungan);

    // Ekstrak data bulan, target, dan realisasi dari data yang dikirim
    const bulan = semuakunjungan.map(item => item.bulann);
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
            text: 'Agregat Target dan Realisasi Kunjungan'
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



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data yang diambil dari server menggunakan Blade templating
        var categories = [
            @foreach($negaraData as $data)
                '{{ $data['name'] }}',
            @endforeach
        ];
        
        var seriesData = [
            @foreach($negaraData as $data)
                {{ $data['jml_wisman_laki'] + $data['jml_wisman_perempuan'] }},
            @endforeach
        ];

        // Konfigurasi Highcharts
        Highcharts.chart('chartbar', {
            chart: {
                type: 'bar', // Tipe chart batang horizontal
                height: 400
            },
            title: {
                text: 'Mancanegara', // Judul grafik
                align: 'center'
            },
            xAxis: {
                categories: categories, // Nama negara
                title: {
                    text: 'Negara'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Kunjungan',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' kunjungan'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true // Tampilkan nilai di atas batang
                    }
                }
            },
            series: [{
                name: 'Total Kunjungan',
                data: seriesData,
                colorByPoint: true // Pewarnaan otomatis setiap batang
            }],
            credits: {
                enabled: false // Hilangkan branding Highcharts
            },
            legend: {
                enabled: false // Hilangkan legenda (opsional jika tidak diperlukan)
            }
        });
    });
</script>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            var categories = @json($bulan);
            // Data bulan yang dikirim dari Laravel

            // Debug hasil konversi
            console.log('Nama bulan:', categories);

            // Data series yang dikirim dari Laravel
            var series = [
                {
                    name: 'Wisata',
                    data: @json($totalWisataAll) // Contoh: [10, 20, 30, ...]
                },
                {
                    name: 'Kuliner',
                    data: @json($totalKulinerAll)
                },
                {
                    name: 'Akomodasi',
                    data: @json($totalAkomodasiAll)
                },
                {
                    name: 'Event',
                    data: @json($totalEventAll)
                }
            ];

            // Debug data series
            console.log('Data series:', series);

            // Membuat grafik dengan Highcharts
            Highcharts.chart('chartkunjungan', {
                chart: {
                    type: 'column',
                    height: 400
                },
                title: {
                    text: 'Jumlah Kunjungan Berdasarkan Kategori'
                },
                xAxis: {
                    categories: categories, // Nama bulan hasil konversi
                    title: {
                        text: 'Bulan'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Kunjungan'
                    }
                },
                tooltip: {
                    shared: true,
                    valueSuffix: ' kunjungan'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: series, // Data yang ditampilkan pada grafik
                credits: {
                    enabled: false
                }
            });
        });
    </script>

<script src="https://code.highcharts.com/highcharts-3d.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data dari server
        var totalKunjunganLaki = @json($totalKunjunganLaki);
        var totalKunjunganPerempuan = @json($totalKunjunganPerempuan);
        var categories = @json($bulan); // Nama bulan

        // Konfigurasi Highcharts
        Highcharts.chart('chart', {
            chart: {
                type: 'column', // Grafik kolom vertikal
                height: 400,
                options3d: {
                    enabled: true, // Aktifkan efek 3D
                    alpha: 15,
                    beta: 15,
                    depth: 50,
                    viewDistance: 25
                }
            },
            title: {
                text: 'Jumlah Kunjungan Berdasarkan Jeniskelamin' // Judul grafik
            },
            xAxis: {
                categories: categories, // Nama bulan
                title: {
                    text: 'Bulan' // Label sumbu X
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Kunjungan' // Label sumbu Y
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: ' kunjungan' // Menambahkan suffix pada tooltip
            },
            plotOptions: {
                column: {
                    depth: 25, // Kedalaman kolom untuk efek 3D
                    stacking: 'normal', // Data ditampilkan dalam satu batang (stacked)
                    dataLabels: {
                        enabled: true // Tampilkan nilai pada batang
                    }
                }
            },
            series: [
                {
                    name: 'Laki-Laki',
                    data: totalKunjunganLaki, // Data laki-laki
                    color: '#007bff' // Warna khusus untuk kategori ini
                },
                {
                    name: 'Perempuan',
                    data: totalKunjunganPerempuan, // Data perempuan
                    color: '#ff4081' // Warna khusus untuk kategori ini
                }
            ],
            credits: {
                enabled: false // Hilangkan branding Highcharts
            }
        });
    });
</script>


@endsection
