@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        
       
           
        <!-- Tabel Data Kunjungan Per Bulan -->
        <!-- Map card -->
        <div class="card">
            <div class="card-header">
                <form action="{{ route('account.kuliner.kunjungankuliner.dashboard') }}" method="GET" class="mb-4">
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
              <!-- card tools -->
              <div class="card-tools">

                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            
            <div class="card-body">
              <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                        <h3>{{  $totalKeseluruhan['total_wisman_laki'] + $totalKeseluruhan['total_laki_laki'] }}</h3>
            
                        <p>Pengunjung Laki Laki</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-male"></i>
                        </div>
                    </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3> {{ $totalKeseluruhan['total_laki_laki'] + 
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
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                        <h3>{{ $totalKeseluruhan['total_wisman_perempuan'] +$totalKeseluruhan['total_perempuan'] }}</h3>
            
                        <p>Pengunjung Perempuan</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-female"></i>
                        </div>
                    </div>
                   
                    </div>
                    <!-- ./col -->
                  
                    <!-- ./col -->
                </div>
            <div id="chart"></div>
            <div id="charttrend"></div>
        <div id="chartstok"></div>


      <!-- /.row -->
        <div class="row">
            <div class="col">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3> {{ $totalKeseluruhan['total_laki_laki'] + 
                        $totalKeseluruhan['total_perempuan']  }}</h3>
                    <p>Jumlah Pengunjung Nusantara</p>
                
                </div>
                <div class="icon">
                <i class="ion ion-bag"></i>
                </div>
            </div>
            </div>
        </div>

        <div class="row">
            @foreach ($kelompok as $namaKelompok)
                <div class="col">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                                return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum(function($item) {
                                    return $item['jumlah_laki_laki'] + $item['jumlah_perempuan'];
                                });
                            }) }}</h3>
                
                            <p>{{ $namaKelompok->kelompokkunjungan_name }}</p>
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
                        <h3> {{ 
                            $totalKeseluruhan['total_wisman_laki'] + 
                            $totalKeseluruhan['total_wisman_perempuan'] }}</h3>
            
                        <p>Jumlah Pengunjung Mancanegara</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                        <table id="example1" class="table table-striped">
                                    @foreach ($wismannegara as $negara)
                                        <tr>
                                        <td> {{ $negara->wismannegara_name }}</td>
                                        <td style="text-align: right;">{{ collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                                            return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum(function ($item) {
                                                return $item['jml_wisman_laki'] + $item['jml_wisman_perempuan'];
                                            });
                                        }) }}</td>
                                        </tr>
                                    @endforeach
                        
                        </table>
                </div>
            </div>
        </div>
        <div id="chartbar"></div>

        
                <!-- /.card-body-->
               
       
            <!-- /.card -->



            <div class="card">
                <div class="card-header border-0">
                    <!-- card tools -->
                    <div class="card-tools">
               
                            <button class="btn btn-outline-success btn-sm" id="export-to-excel">Download Excel</button> <!-- Tombol Export -->
                            <button class="btn btn-outline-danger btn-sm" id="export-to-pdf">Download PDF</button> <!-- Tombol Export PDF -->
            
                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <table id="TabelKunjunganBulan" class="table table-bordered table-striped">
                        <thead>
                            <tr><th colspan="{{ 3 + (count($kelompok) * 2) + (count($wismannegara) * 2) }}">
                                <h2 style="text-align: center; text-transform: uppercase;">
                                    Rekap Data Kunjungan {{$kuliner->namakuliner}} perbulan Tahun {{ $year }}
                                </h2>
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="3">Bulan</th>
                                <th rowspan="3">Total</th>
                                <th colspan="{{ count($kelompok) * 2 }}" style="text-align: center;">Kuliner Nusantara</th>
                                <th colspan="2" style="text-align: center;">Kuliner Mancanegara</th>
                            </tr>
                            <tr>
                                @foreach ($kelompok as $namaKelompok)
                                    <th colspan="2" style="text-align: center;">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                                @endforeach
                                <th colspan="2" style="text-align: center;">Total Kuliner Mancanegara</th>
                            </tr>
                            <tr>
                                @foreach ($kelompok as $namaKelompok)
                                    <th style="text-align: center;">L</th>
                                    <th style="text-align: center;">P</th>
                                @endforeach
                                <th style="text-align: center;">Laki - Laki</th>
                                <th style="text-align: center;">Perempuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kunjungan as $month => $dataBulan)
                                @php
                                    // Cek apakah semua nilai pada bulan tersebut adalah 0
                                    $isZero = ($dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan']) == 0;
                                    foreach ($kelompok as $namaKelompok) {
                                        if ($dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') > 0 || $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') > 0) {
                                            $isZero = false;
                                            break;
                                        }
                                    }
                                    if ($dataBulan['jml_wisman_laki'] > 0 || $dataBulan['jml_wisman_perempuan'] > 0) {
                                        $isZero = false;
                                    }
                                @endphp
                                <tr class="{{  $isZero ? 'bg-navy color-palette' : '' }}">
                                    <td>{{ \Carbon\Carbon::createFromFormat('!m', $month)->locale('id')->isoFormat('MMMM') }}</td>

                                    <td>
                                        {{ $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'] }}
                                    </td>
                                    @foreach ($kelompok as $namaKelompok)
                                        <td>{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') }}</td>
                                        <td>{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') }}</td>
                                    @endforeach
                                    <td>{{ $dataBulan['jml_wisman_laki'] ?: 0 }}</td>
                                    <td>{{ $dataBulan['jml_wisman_perempuan'] ?: 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <th>Total Keseluruhan</th>
                                <th>
                                    {{ collect($kunjungan)->sum(function($dataBulan) {
                                        return $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'];
                                    }) }}
                                </th>
                                @foreach ($kelompok as $namaKelompok)
                                    <th>{{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                                        return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki');
                                    }) }}</th>
                                    <th>{{ collect($kunjungan)->sum(function($dataBulan) use ($namaKelompok) {
                                        return $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan');
                                    }) }}</th>
                                @endforeach
                                <th>{{ $totalKeseluruhan['total_wisman_laki'] }}</th>
                                <th>{{ $totalKeseluruhan['total_wisman_perempuan'] }}</th>
                            </tr>
                        </tfoot>
                    </table>
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
            data: [
                @foreach($negaraData as $data)
                    {{ $data['value'] }},
                @endforeach
            ]
        }],
        chart: {
            type: 'bar',
            height: 200
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
        series: [
            @foreach ($kelompokData as $data)
                {{ $data['value'] }},
            @endforeach
        ],
        chart: {
            width: 380,
            type: 'donut',
        },
        labels: [
            @foreach ($kelompokData as $data)
                "{{ $data['name'] }}",
            @endforeach
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
        series: [{
            name: 'Total Kunjungan',
            data: @json($totalKunjungan) // Replace with your PHP variable for data
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: 'Trends Kunjungan berdasarkan Bulan',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // Alternating row colors
                opacity: 0.5
            }
        },
        xaxis: {
            categories: @json($bulan),  // Menggunakan nama bulan untuk kategori
        }
    };

    var chart = new ApexCharts(document.querySelector("#charttrend"), options);
    chart.render();
</script>
<script>
    // Convert PHP data to JavaScript
    const dataByDate = @json($bytgl); // Data per tanggal

    const dates = [];
    const totalKunjungan = [];

    // Prepare data for the chart
    for (const [date, data] of Object.entries(dataByDate)) {
        dates.push(date);  // Add date to the x-axis
        totalKunjungan.push(
            data.jumlah_laki_laki + data.jumlah_perempuan + data.jml_wisman_laki + data.jml_wisman_perempuan
        );  // Calculate total visitors for each date
    }

    // Chart options using ApexCharts
    var options = {
        series: [{
            name: 'Kunjungan',
            data: totalKunjungan
        }],
        chart: {
            type: 'area',
            stacked: false,
            height: 350,
            zoom: {
                type: 'x',
                enabled: true,
                autoScaleYaxis: true
            },
            toolbar: {
                autoSelected: 'zoom'
            }
        },
        dataLabels: {
            enabled: false
        },
        markers: {
            size: 0,
        },
        title: {
            text: 'Tren Kunjungan Dalam Satutahun',
            align: 'left'
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 90, 100]
            },
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val.toFixed(0);  // Show integer value for visitors
                },
            },
            title: {
                text: 'Tren Kunjungan'
            },
        },
        xaxis: {
            categories: dates,
            type: 'category',
        },
        tooltip: {
            shared: false,
            y: {
                formatter: function (val) {
                    return val.toFixed(0);  // Show integer value for tooltip
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartstok"), options);
    chart.render();
</script>

<script>
        document.getElementById('export-to-pdf').addEventListener('click', function () {
            var element = document.getElementById('TabelKunjunganBulan');
            var opt = {
                margin:       [10, 10, 10, 10],  // Menambahkan margin atas, kanan, bawah, kiri (dalam mm)
                filename:     'Kunjungan_Kuliner_' + new Date().toISOString() + '.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 3 },  // Meningkatkan kualitas gambar
                jsPDF:        { 
                    unit: 'mm', 
                    format: 'letter',  // Format A4
                    orientation: 'landscape'  // Mengatur orientasi menjadi landscape agar lebih lebar
                }
            };
    
            // Menambahkan pengaturan CSS untuk menghindari pemotongan
            html2pdf().from(element).set(opt).save();
        });
    </script>
    <script>
        document.getElementById('export-to-excel').addEventListener('click', function () {
            var table = document.getElementById('TabelKunjunganBulan'); // Ambil tabel berdasarkan ID
            var sheet = XLSX.utils.table_to_book(table, { sheet: 'Kunjungan Kuliner' }); // Konversi tabel menjadi buku Excel
            XLSX.writeFile(sheet, 'Kunjungan_Kuliner_' + new Date().toISOString() + '.xlsx'); // Unduh file Excel
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
@endsection
@endsection
