@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        
       
           
        <!-- Tabel Data Kunjungan Per Bulan -->
        <!-- Map card -->
        <div class="card">
            <div class="card-header">
                <form action="{{ route('account.wisata.kunjunganwisata.dashboard') }}" method="GET" class="mb-4">
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
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3> {{ $totalKeseluruhan['total_laki_laki'] + 
                                    $totalKeseluruhan['total_perempuan']  }}</h3>
                                <p>Nusantara</p>
                            
                            </div>
                            <div class="icon">
                            <i class="ion ion-bag"></i>
                            </div>
                        </div>  
                        <figure class="highcharts-figure">
                            <div id="donut"></div>
                            
                        </figure>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3> {{ 
                                    $totalKeseluruhan['total_wisman_laki'] + 
                                    $totalKeseluruhan['total_wisman_perempuan'] }}</h3>
                    
                                <p>Mancanegara</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>
                        </div>
        
                            <div id="chartbar"></div>
                                {{-- <table id="example1" class="table table-striped">
                                            @foreach ($wismannegara as $negara)
                                                <tr>
                                                <td  style="text-align: center; text-transform: uppercase;"> {{ $negara->wismannegara_name }}</td>
                                                <td style="text-align: right;">{{ collect($kunjungan)->sum(function($dataBulan) use ($negara) {
                                                    return $dataBulan['wisman_by_negara']->get($negara->id, collect())->sum(function ($item) {
                                                        return $item['jml_wisman_laki'] + $item['jml_wisman_perempuan'];
                                                    });
                                                }) }}</td>
                                                </tr>
                                            @endforeach
                                
                                </table> --}}
                        
        
                    </div>
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
                        <figure class="highcharts-figure">
                            <div id="chartstok"></div>
                           
                        </figure>
                        
                        </div>
            </div>
           

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
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalKeseluruhanEven['total_pengunjung'] }}</h3>
                                <p>Even</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-woman"></i>
                                <i class="ion ion-man"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                  
                    <!-- ./col -->
                </div>
                <div class="row">
                    <div class="col-lg-6 col-6">
                    <figure class="highcharts-figure">
                        <div id="jenkel"></div>
                    </figure>
                    </div>
                    <div class="col-lg-6 col-6">

                        <figure class="highcharts-figure">
                            <div id="Totalkunjungan"></div>
            
                        </figure>
                    </div>
                </div>
                


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
                                    Rekap Data Kunjungan {{$wisata->namawisata}} perbulan Tahun {{ $year }}
                                </h2>
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="3">Bulan</th>
                                <th rowspan="3">Total</th>
                                <th colspan="{{ count($kelompok) * 2 }}" style="text-align: center;">Wisata Nusantara</th>
                                <th colspan="2" style="text-align: center;">Wisata Mancanegara</th>
                            </tr>
                            <tr>
                                @foreach ($kelompok as $namaKelompok)
                                    <th colspan="2" style="text-align: center;">{{ $namaKelompok->kelompokkunjungan_name }}</th>
                                @endforeach
                                <th colspan="2" style="text-align: center;">Total Wisata Mancanegara</th>
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
                                    <td  style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::createFromFormat('!m', $month)->locale('id')->isoFormat('MMMM') }}</td>

                                    <td  style="text-align: center; text-transform: uppercase;">
                                        {{ $dataBulan['jumlah_laki_laki'] + $dataBulan['jumlah_perempuan'] + $dataBulan['jml_wisman_laki'] + $dataBulan['jml_wisman_perempuan'] }}
                                    </td>
                                    @foreach ($kelompok as $namaKelompok)
                                        <td  style="text-align: center; text-transform: uppercase;">{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_laki_laki') }}</td>
                                        <td  style="text-align: center; text-transform: uppercase;">{{ $dataBulan['kelompok']->get($namaKelompok->id, collect())->sum('jumlah_perempuan') }}</td>
                                    @endforeach
                                    <td  style="text-align: center; text-transform: uppercase;">{{ $dataBulan['jml_wisman_laki'] ?: 0 }}</td>
                                    <td  style="text-align: center; text-transform: uppercase;">{{ $dataBulan['jml_wisman_perempuan'] ?: 0 }}</td>
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
  <script src="{{ asset('datakunjungan/Highcharts.js') }}"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@section('scripts')
<!-- DataTables  & Plugins -->
<script>
    var totalKunjunganLaki = @json($totalKunjunganLaki); 
    var totalKunjunganPerempuan = @json($totalKunjunganPerempuan); 
    var bulan = @json($bulan);
    
    Highcharts.chart('jenkel', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                viewDistance: 25,
                depth: 40
            }
        },

        title: {
            text: 'Statistik Jenis Kelamin',
            align: 'left'
        },

        xAxis: {
            categories: bulan,
            labels: {
                skew3d: true,
                style: {
                    fontSize: '16px'
                }
            }
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Jumlah Kunjungan',
                skew3d: true,
                style: {
                    fontSize: '16px'
                }
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> ' +
                '{series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {   
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'Laki-Laki',
            data: totalKunjunganLaki,
            stack: 'Total',
            color: 'rgb(44,175,254)' // Warna pink untuk Perempuan
        }, {
            name: 'Perempuan',
            data: totalKunjunganPerempuan,
            stack: 'Total',
             color: 'rgb(213,104,251)' // Warna pink untuk Perempuan
        }]
    });
</script>
<script>
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
            categories: @json($bulan), // Using the month names (bulan) from PHP
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
            name: 'Total Kunjungan',
            data: @json($totalKunjungan) // Using the totalKunjungan data from PHP
        }]
    });
</script>
<script>
    Highcharts.chart('donut', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Wisata Nusantara'
        },
        tooltip: {
            valueSuffix: ''
        },
       
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: [{
                    enabled: true,
                    distance: 20
                }, {
                    enabled: true,
                    distance: -40,
                    format: '{point.percentage:.1f}%',
                    style: {
                        fontSize: '1.2em',
                        textOutline: 'none',
                        opacity: 0.7
                    },
                    filter: {
                        operator: '>',
                        property: 'percentage',
                        value: 10
                    }
                }]
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach ($kelompokData as $data)
                    {
                        name: "{{ $data['name'] }}",
                        y: {{ $data['value'] }},
                        @if($loop->first)
                            sliced: true,
                            selected: true,
                        @endif
                    },
                @endforeach
            ]
        }]
    });
</script>
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
                borderRadius: 4,
            borderRadiusApplication: 'end',
            horizontal: true,
            distributed: true,
                dataLabels: {
          enabled: false
        },
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

    // Convert date format to abbreviated month (e.g., 'Jan', 'Feb', 'Mar')
    const formattedDates = dates.map(date => {
        const month = new Date(date).toLocaleString('default', { month: 'short' });
        return month;
    });

    Highcharts.chart('chartstok', {
        chart: {
            type: 'area',
            zooming: {
                type: 'x' // Enable zooming in x-axis
            }
        },
        title: {
            text: 'Tren Kunjungan Dalam Satutahun',
            align: 'left'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' :
                'Pinch the chart to zoom in',
            align: 'left'
        },
        xAxis: {
            categories: formattedDates, // Use abbreviated months
            type: 'category', // Category type for the x-axis
            title: {
                text: 'Bulan'
            }
        },
        yAxis: {
            title: {
                text: 'Jumlah Kunjungan'
            },
            labels: {
                formatter: function () {
                    return this.value.toFixed(0); // Show integer value for visitors
                }
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                color: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, 'rgb(199, 113, 243)'],
                        [0.7, 'rgb(76, 175, 254)']
                    ]
                },
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },
        series: [{
            name: 'Kunjungan',
            data: totalKunjungan, // Data for the visitors
        }],
        tooltip: {
            shared: true, // Enable shared tooltip for multiple series
            valueDecimals: 0, // Show integer value
            headerFormat: '<b>{point.key}</b><br>', // Date header format
            pointFormat: '{series.name}: {point.y}<br>' // Show the visitor count for each date
        }
    });
</script>




<script>
        document.getElementById('export-to-pdf').addEventListener('click', function () {
            var element = document.getElementById('TabelKunjunganBulan');
            var opt = {
                margin:       [10, 10, 10, 10],  // Menambahkan margin atas, kanan, bawah, kiri (dalam mm)
                filename:     'Kunjungan_Wisata_' + new Date().toISOString() + '.pdf',
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
            var sheet = XLSX.utils.table_to_book(table, { sheet: 'Kunjungan Wisata' }); // Konversi tabel menjadi buku Excel
            XLSX.writeFile(sheet, 'Kunjungan_Wisata_' + new Date().toISOString() + '.xlsx'); // Unduh file Excel
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
@endsection
@endsection
