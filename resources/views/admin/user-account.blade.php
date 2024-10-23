@extends('layouts.admin.admin')

@section('content')
    <!-- Main content -->
    <style>
        #map {
            height: 900px;
            width: 100%;
            position: relative;
            overflow: auto;
        }

        .text-container {
            width: 150px;
            /* Atur lebar elemen sesuai kebutuhan */
            /* Menampilkan tanda elipsis (...) jika teks melebihi lebar */
        }
    </style>
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <section class="content">
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.article.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Article</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_post }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-newspaper fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.users.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Jumlah Pengguna</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_user }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa-fw fas fa-user fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.tag.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah
                                                    Tag</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                            {{ $jumlah_tag }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-tags fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.baners.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Jumlah Banner</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_banner }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-images fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.wisata.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Destinasi</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_wisata }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-university fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.kuliner.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Jumlah Kuliner</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_kuliner }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-store fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.akomodasi.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah
                                                    Akomodasi</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                            {{ $jumlah_akomodasi }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa-fw fas fa-hotel fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.ekraf.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Jumlah Ekraf</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_ekraf }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dice-d20 fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.paketwisata.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Paket Wisata</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_paket_wisata }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dice-d6 fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.pesanantiket.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Pesanan Tiket Wisata</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_pesanan_tiket_wisata }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.kulinerproduk.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Jumlah Prodak Kuliner</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_proudct_kuliner }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-utensils fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.room.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Jumlah Kamar</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_room }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-bed fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.evencalender.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Jumlah Event</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_event }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-film fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.categorywisata.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Jenis Wisata</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_jeniswisata }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.support.index') }}" class="nav-link ? 'active' : '' ">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Jumlah Support</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_support }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-image fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="{{ route('admin.fasilitas.index') }}" class="nav-link ? 'active' : '' ">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Jumlah Fasilitas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_fasilitas }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-person-booth fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="{{ route('admin.banerpromo.index') }}" class="nav-link ? 'active' : '' ">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah Baner Promo</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_baner_promo }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-image fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="{{ route('admin.wisatawans.index') }}" class="nav-link ? 'active' : '' ">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Wisatawan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_wisatawan }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-fw fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="{{ route('admin.categorykuliner.index') }}" class="nav-link ? 'active' : '' ">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Jumlah Jenis Kuliner</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_jeniskuliner }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-fw fas fa-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('admin.categoryakomodasi.index') }}" class="nav-link ? 'active' : '' ">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Jumlah Jenis Akomodasi</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_jenisakomodasi }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-fw fas fa-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('admin.company.index') }}" class="nav-link ? 'active' : '' ">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Jumlah Pengusaha</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_company }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{route('admin.pesanantiket.index')}}" class="nav-link ? 'active' : '' ">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Monitoring Tiket</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_Tiket }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{route('admin.pesanankuliner.index')}}" class="nav-link ? 'active' : '' ">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Monitoring Pesanan Kuliner</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_PesanKuliner }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{route('admin.reserv.index')}}" class="nav-link ? 'active' : '' ">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Monitoring Reservasi Akomodasi</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_Reservasi }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                </div>


                    <!-- Content Row -->

                    {{-- post --}}

                    <div class="card border-bottom-primary">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Post Hari Ini</h6>
                        </div>
                        <div class="card-body">
                            @if ($post->count() >= 1)
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Sampul</th>
                                            <th scope="col">Judul</th>
                                            <th scope="col">Tag</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($post as $row)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td><img src="/upload/post/{{ $row->sampul }}" alt=""
                                                        width="80px" height="80px"></td>
                                                <td>{{ $row->judul }}</td>
                                                <td>
                                                    @foreach ($row->tag as $post_tag)
                                                        <span class="badge badge-secondary">{{ $post_tag->nama }}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info" role="alert">
                                    Anda tidak memiliki post terbaru hari ini
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- kategori --}}



                    {{-- tag --}}

                    <div class="card border-bottom-info mt-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Tag Hari Ini</h6>
                        </div>
                        <div class="card-body">
                            @if ($tag->count() >= 1)
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tag</th>
                                            <th scope="col">Slug</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tag as $row)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $row->nama }}</td>
                                                <td>{{ $row->slug }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info" role="alert">
                                    Anda tidak memiliki tag terbaru hari ini
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- banner --}}

                    <div class="card border-bottom-warning mt-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-warning">Banner Hari Ini</h6>
                        </div>
                        <div class="card-body">
                            @if ($banner->count() >= 1)
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Sampul</th>
                                            <th scope="col">Banner</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banner as $row)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td><img src="/upload/banner/{{ $row->sampul }}" width="80px"
                                                        height="80px" alt=""></td>
                                                <td>{{ $row->judul }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info" role="alert">
                                    Anda tidak memiliki banner terbaru hari ini
                                </div>
                            @endif
                        </div>
                    </div>
                    <div id="map"></div>

                    <div>
                        <h2>
                            <label for="jenis">Pilih Jenis</label>
                            <select id="jenis" onchange="filterMarkers()">
                                <option value="all">Semua</option>
                                <option value="wisata">Wisata</option>
                                <option value="kuliner">Kuliner</option>
                                <option value="akomodasi">Akomodasi</option>
                            </select>
                        </h2>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
<link href="{{ asset('map-icons-master/dist/css/map-icons.css') }}" rel="stylesheet" />

<script type="text/javascript" src="{{ asset('map-icons-master/dist/js/map-icons.js') }}"></script>
<style>
    #map-canvas {
        height: 80%;
        width: 80%;
        margin: 0 auto 0 auto;
    }

    .map-icon-label .map-icon {
        font-size: 12px;
        color: #FFFFFF;
        text-align: center;
        white-space: nowrap;
    }

    html,
    body {
        height: 100%;
    }

    .customMarker.wisata {
        position: absolute;
        cursor: pointer;
        background: rgba(251,200,83,255);
        width: 60px;
        height: 60px;
        left: /* koordinat geografis absolut */;
    top: /* koordinat geografis absolut */;
    transform: translate(-50%, -50%);
        border-radius: 50%;
        padding: 0px;
    }

    .customMarker.kuliner {
        position: absolute;
        cursor: pointer;
        background: rgba(184,215,98,255);
        width: 60px;
        height: 60px;
        left: /* koordinat geografis absolut */;
        top: /* koordinat geografis absolut */;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        padding: 0px;
    }

    .customMarker.akomodasi {
        position: absolute;
        cursor: pointer;
        background: rgba(236,111,55,255);
        width: 60px;
        height: 60px;
        /* -width/2 */
        left: /* koordinat geografis absolut */;
    top: /* koordinat geografis absolut */;
    transform: translate(-50%, -50%);
        border-radius: 50%;
        padding: 0px;
    }

    .customMarker:after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 20px;
        border-width: 10px 10px 0;
        border-style: solid;
        border-color: #424242 transparent;
        display: block;
        width: 0;
    }

    .customMarker img {
        width: 50px;
        height: 50px;
        margin: 5px;
        border-radius: 50%;
    }
    .customMarker:hover {
    transform: translate(-50%, -50%) scale(1.2);
}

.customMarker:hover img {
    transform: scale(1.2);
}
</style>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_UNRESTRICTED') }}">
</script>
@section('scripts')
    <script>
        var markers = [];

        function filterMarkers() {
            var jenis = document.getElementById('jenis').value;
            for (var i = 0; i < markers.length; i++) {
                var marker = markers[i];
                if (jenis === 'all') {
                    $('.wisata').attr('hidden', false)
                    $('.kuliner').attr('hidden', false)
                    $('.akomodasi').attr('hidden', false)
                } else if (jenis === 'wisata') {
                    $('.wisata').attr('hidden', false)
                    $('.kuliner').attr('hidden', true)
                    $('.akomodasi').attr('hidden', true)
                } else if (jenis === 'kuliner') {
                    $('.kuliner').attr('hidden', false)
                    $('.wisata').attr('hidden', true)
                    $('.akomodasi').attr('hidden', true)
                } else if (jenis === 'akomodasi') {
                    $('.akomodasi').attr('hidden', false)
                    $('.wisata').attr('hidden', true)
                    $('.kuliner').attr('hidden', true)
                }
            }
        }

        function CustomMarker(latlng, map, imageSrc, jenis) {
            this.latlng_ = latlng;
            this.imageSrc = imageSrc;

            this.setMap(map);
        }
        CustomMarker.prototype = new google.maps.OverlayView();
        CustomMarker.prototype.draw = function() {
            // Check if the div has been created.
            var div = this.div_;
            if (!div) {
                // Create a overlay text DIV
                div = this.div_ = document.createElement('div');
                // Create the DIV representing our CustomMarker
                div.className = "customMarker " + this.jenis;

                var img = document.createElement("img");
                img.src = this.imageSrc;
                div.appendChild(img);
                var me = this;
                google.maps.event.addDomListener(div, "click", function(event) {
                    google.maps.event.trigger(me, "click");
                });

                // Then add the overlay to the DOM
                var panes = this.getPanes();
                panes.overlayImage.appendChild(div);
            }
            // Position the overlay 
            var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
            if (point) {
                div.style.left = point.x + 'px';
                div.style.top = point.y + 'px';
            }
        };

        CustomMarker.prototype.remove = function() {
            // Check if the overlay was on the map and needs to be removed.
            if (this.div_) {
                this.div_.parentNode.removeChild(this.div_);
                this.div_ = null;
            }
        };

        CustomMarker.prototype.getPosition = function() {
            return this.latlng_;
        };

        var map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng({{ $latitude }}, {{ $longitude }}),
            zoom: 12,
            minZoom: 6,
            maxZoom: 17,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.DEFAULT
            },
        });
        map.data.loadGeoJson('/js/Kuninganbatas.geojson');

        // addMarkers(map);

        var wisata = @json($mapWisatas);
        var kuliner = @json($mapKuliners);
        var akomodasi = @json($mapAkomodasis);


        for (var i = 0; i < wisata.length; i++) {
            var wisatas = wisata[i];
            var photoUrl = wisatas.thumbnail;
            var jenis = 'wisata';

            var marker = new CustomMarker(new google.maps.LatLng(wisatas.latitude, wisatas.longitude), map, photoUrl)
            marker.jenis = jenis;

            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', (function(marker, wisatas) {
                return function() {
                    infowindow.setContent(generateContentwisata(wisatas))
                    infowindow.open(map, marker);
                }
            })(marker, wisatas));
            markers.push(marker);

        }

        for (var i = 0; i < kuliner.length; i++) {
            var kuliners = kuliner[i];
            var photoUrl = kuliners.thumbnail;
            var jenis = 'kuliner'

            var marker = new CustomMarker(new google.maps.LatLng(kuliners.latitude, kuliners.longitude), map, photoUrl,
                jenis)
            marker.jenis = jenis;

            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', (function(marker, kuliners) {
                return function() {
                    infowindow.setContent(generateContentKuliner(kuliners))
                    infowindow.open(map, marker);
                }
            })(marker, kuliners));

            markers.push(marker);

        }

        for (var i = 0; i < akomodasi.length; i++) {
            var akomodasis = akomodasi[i];
            var photoUrl = akomodasis.thumbnail;
            var jenis = 'akomodasi'

            var marker = new CustomMarker(new google.maps.LatLng(akomodasis.latitude, akomodasis.longitude), map, photoUrl,
                jenis)
            marker.jenis = jenis;

            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', (function(marker, akomodasis) {
                return function() {
                    infowindow.setContent(generateContentAkomodasi(akomodasis))
                    infowindow.open(map, marker);
                }
            })(marker, akomodasis));

            markers.push(marker);

        }


        function generateContentwisata(wisata) {
            var content = `
                  <div>
                      <a href="{{ route('admin.detailwisata', '') }}/` + wisata.id + `" title="View: ` + wisata
                .namawisata + `">` + wisata.namawisata + `</a>
                  </div>
                      <a href="{{ route('admin.detailwisata', '') }}/` + wisata.id + `"><img src="` + wisata
                .thumbnail + `" alt="` + wisata.namawisata + `" class="align size-medium_large" width="140" height="93"></a>
                         <div class="text-container">` + wisata.alamat + `</div>
                         <a href="https://www.google.com/maps/dir/?api=1&destination=` + wisata.latitude + `,` + wisata
                .longitude + `">Arahkan saya</a>
                    `;

            return content;

        }

        function generateContentKuliner(kuliner) {
            var content = `
                  <div>
                      <a href="{{ route('admin.detailkuliner', '') }}/` + kuliner.id + `" title="View: ` + kuliner
                .namakuliner + `">` + kuliner.namakuliner + `</a>
                  </div>
                      <a href="{{ route('admin.detailkuliner', '') }}/` + kuliner.id + `"><img src="` + kuliner
                .thumbnail + `" alt="` + kuliner.namakuliner + `" class="align size-medium_large" width="140" height="93"></a>
                        <div class="text-container">` + kuliner.alamat + `</div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=` + kuliner.latitude + `,` +
                kuliner.longitude + `">Arahkan saya</a>
                    `;
            return content;

        }

        function generateContentAkomodasi(akomodasi) {
            var content = `
                  <div>
                      <a href="{{ route('admin.detailakomodasi', '') }}/` + akomodasi.id + `" title="View: ` +
                akomodasi.namaakomodasi + `">` + akomodasi.namaakomodasi + `</a>
                  </div>
                      <a href="{{ route('admin.detailakomodasi', '') }}/` + akomodasi.id + `"><img src="` + akomodasi
                .thumbnail + `" alt="` + akomodasi.namaakomodasi + `" class="align size-medium_large" width="140" height="93"></a>
                        <div class="text-container">` + akomodasi.alamat + `</div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=` + akomodasi.latitude + `,` +
                akomodasi.longitude + `">Arahkan saya</a>
                    `;
            return content;

        }
    </script>
@endsection
