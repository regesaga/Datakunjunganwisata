@extends('layouts.datakunjungan.datakunjungan')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        
       
           
        <!-- Tabel Data Kunjungan Per Bulan -->
        <!-- Map card -->
        <div class="card bg-gradient-primary">
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
                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
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
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3> {{ $totalKeseluruhan['total_laki_laki'] + 
                                $totalKeseluruhan['total_perempuan']  }}</h3>
                            <p>Jumlah Pengunjung Nusantara</p>
                           
                        </div>
                        <div class="icon">
                        <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3> {{ 
                                $totalKeseluruhan['total_wisman_laki'] + 
                                $totalKeseluruhan['total_wisman_perempuan'] }}</h3>
                
                            <p>Jumlah Pengunjung Mancanegara</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                    </div>
                    <!-- ./col -->
                  
                    <!-- ./col -->
                </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{ $totalKeseluruhan['total_laki_laki'] }}</h3>

            <p>Pengunjung Laki Laki Nusantara</p>
            </div>
            <div class="icon">
            <i class="ion ion-male"></i>
            </div>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{ $totalKeseluruhan['total_perempuan'] }}</h3>

            <p>Pengunjung Perempuan Nusantara</p>
            </div>
            <div class="icon">
            <i class="ion ion-female"></i>
            </div>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
            <h3>{{ $totalKeseluruhan['total_wisman_laki'] }}</h3>

            <p>Pengunjung Laki Laki Mancanegara</p>
            </div>
            <div class="icon">
            <i class="ion ion-male"></i>
            </div>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
            <h3>{{ $totalKeseluruhan['total_wisman_perempuan'] }}</h3>

            <p>Pengunjung Perempuan Mancanegara</p>
            </div>
            <div class="icon">
            <i class="ion ion-female"></i>
            </div>
        </div>
        </div>
        <!-- ./col -->
    </div>
            </div>
            <!-- /.card-body-->
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.card -->
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Total Laki-Laki Domestik</th>
                            <th>Total Perempuan Domestik</th>
                            <th>Total Laki-Laki Mancanegara</th>
                            <th>Total Perempuan Mancanegara</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(range(1, 12) as $month)
                            <tr>
                                <td>{{ DateTime::createFromFormat('!m', $month)->format('F') }}</td>
                                <td>{{ $kunjungan[$month]['total_laki_laki'] ?? 0 }}</td>
                                <td>{{ $kunjungan[$month]['total_perempuan'] ?? 0 }}</td>
                                <td>{{ $kunjungan[$month]['total_wisman_laki'] ?? 0 }}</td>
                                <td>{{ $kunjungan[$month]['total_wisman_perempuan'] ?? 0 }}</td>
                                <td>
                                    {{ ($kunjungan[$month]['total_laki_laki'] ?? 0) + 
                                       ($kunjungan[$month]['total_perempuan'] ?? 0) + 
                                       ($kunjungan[$month]['total_wisman_laki'] ?? 0) + 
                                       ($kunjungan[$month]['total_wisman_perempuan'] ?? 0) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total Keseluruhan</th>
                            <th>{{ $totalKeseluruhan['total_laki_laki'] }}</th>
                            <th>{{ $totalKeseluruhan['total_perempuan'] }}</th>
                            <th>{{ $totalKeseluruhan['total_wisman_laki'] }}</th>
                            <th>{{ $totalKeseluruhan['total_wisman_perempuan'] }}</th>
                            <th>
                                {{ $totalKeseluruhan['total_laki_laki'] + 
                                   $totalKeseluruhan['total_perempuan'] + 
                                   $totalKeseluruhan['total_wisman_laki'] + 
                                   $totalKeseluruhan['total_wisman_perempuan'] }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
@section('scripts')
<!-- DataTables  & Plugins -->

@endsection
@endsection
