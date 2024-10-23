@extends('layouts.author.account')

@section('content')
    <div class="account-bdy p-3">
        <div class="row mb-3">
            <div class="col-xl-2 col-sm-6 py-2">
                <a href="{{ route('account.wisata.tiketwisata') }}">
                  <div class="card dashboard-card text-white h-100 shadow">
                      <div class="card-body primary-bg">
                          <div class="rotate">
                              <i class="fas fa-list fa-4x"></i>
                          </div>
                          <h6 class="text-uppercase">Validasi Tiket</h6>
                          <h1 class=""></h1>
                      </div>
                  </div>
                </a>
              </div>
          <div class="col-xl-2 col-sm-6 py-2">
              <a href="{{ route('account.wisata.user-wisatakuliner') }}">
              <div class="card dashboard-card text-white  h-100 shadow">
                  <div class="card-body bg-success">
                      <div class="rotate">
                          <i class="fas fa-download fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Kuliner</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
              </a>
          </div>
          <div class="col-xl-2 col-sm-6 py-2">
            <a href="{{ route('account.wisata.user-wisataakomodasi') }}">
            <div class="card dashboard-card text-white  h-100 shadow">
                <div class="card-body bg-info">
                    <div class="rotate">
                        <i class="fas fa-hotel fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Akomodasi</h6>
                    <h1 class=""></h1>
                </div>
            </div>
            </a>
        </div>
          <div class="col-xl-2 col-sm-6 py-2">
              <a href="{{ route('account.wisata.guide.index') }}">
                <div class="card dashboard-card text-white h-100 shadow">
                    <div class="card-body bg-danger">
                        <div class="rotate">
                            <i class="fas fa-th fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Paket Wisata</h6>
                        <h1 class=""></h1>
                    </div>
                </div>
              </a>
          </div>
          <div class="col-xl-2 col-sm-6 py-2">
            <a href="{{ route('account.wisata.even.index') }}">
              <div class="card dashboard-card text-white h-100 shadow">
                  <div class="card-body bg-warning">
                      <div class="rotate">
                          <i class="fas fa-file fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Event</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
            </a>
        </div>
        <div class="col-xl-2 col-sm-6 py-2">
            <a href="{{ route('account.wisata.banerpromo.index') }}">
              <div class="card dashboard-card text-white h-100 shadow">
                  <div class="card-body bg-info">
                      <div class="rotate">
                          <i class="fas fa-file fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Baner Promo</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
            </a>
        </div>
      </div>

      <section class="author-company-info">
          <div class="row">
              <div class="col-sm-12 col-md-12">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="card-title">Kelola Detail Profile</h4>
                          
                          <div class="mb-3 d-flex">
                            @if(!$company)
                            <a href="{{route('account.wisata.company.create')}}" class="btn primary-btn mr-2">Isi Detail Perusahaan</a>
                            @else
                            <a href="{{route('account.wisata.company.edit')}}" class="btn secondary-btn mr-2">Edit Perusahaan</a>
                            
                            @endif
                          </div>
                          @if($company)
                          <div class="row">
                              <div class="col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="table-responsive">
                                                <table class=" table table-bordered table-striped table-hover datatable datatable-ShowWisata">
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            Nama Pemilik 
                                                        </th>
                                                        <td>
                                                            {{$company->nama}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Jenis Usaha
                                                        </th>
                                                        <td>
                                                            {{$company->title}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Telphone
                                                        </th>
                                                        <td>
                                                            <span class="badge badge-primary"><i class="fas fa-phone">&nbsp;{{$company->phone}}</i></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                          </div>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </section>
        @if($company)
            <section class="author-company-info">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Kelola Detail Wisata</h4>
                                
                                <div class="mb-3 d-flex">
                                    @if(!$wisata)
                                        <a href="{{route('account.wisata.wisata.create')}}" class="btn primary-btn mr-2">Isi Detail Wisata</a>
                                    @else
                                        <a href="{{route('account.wisata.wisata.edit')}}" class="btn secondary-btn mr-2">Edit Wisata</a>
                                    @endif
                                </div>
                                @if($wisata)
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class=" table table-bordered table-striped table-hover datatable datatable-ShowWisata">
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        Nama Objek Wisata
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->namawisata }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Kategori Wisata
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->getCategory->category_name ?? '' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Alamat
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->alamat }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Kecamatan
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->kecamatan->Kecamatan}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Status
                                                                    </th>
                                                                    <td>
                                                                        @if($wisata->active == 1)
                                                                        <span class="badge badge-success ">Publish</span>
                                                                    @else
                                                                    <span class="badge badge-secondary ">Draft</span>
                                                                    @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        <i class="ri-eye-fill"></i>Melihat
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->views }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Deskripsi
                                                                    </th>
                                                                    <td>
                                                                        {!! $wisata->deskripsi !!}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Photo
                                                                    </th>
                                                                    <td>
                                                                        @foreach($wisata->photos as $key => $media)
                                                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                                                <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                                                            </a>
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Fasilitas
                                                                    </th>
                                                                    <td>
                                                                        @foreach($wisata->fasilitas as $key => $fasilitas)
                                                                        <span class="badge badge-primary">{{ $fasilitas->fasilitas_name }}</span>
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Instagram
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->instagram }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Web
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->web }}
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Telphon
                                                                    </th>
                                                                    <td>
                                                                        <span class="badge badge-primary"><i class="fas fa-phone">&nbsp;{{ $wisata->telpon }}</i></span>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <th>
                                                                    Jam Oprasional
                                                                    </th>
                                                                    <td>
                                                                        {{ $wisata->jambuka }} S.d {{ $wisata->jamtutup }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                    Harga Tiket
                                                                    </th>
                                                                    
                                                                        <td>@foreach ($hargatiket as $ticketCategory)
                                                                            <span class="badge badge-info ">  {{ $ticketCategory->kategori }} Rp.{{ $ticketCategory->harga }}</span>
                                                                @endforeach
                                    
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                    Kapasitas Pengunjung
                                                                    </th>
                                                                    <td>
                                                                        <span class="badge badge-primary">{{$wisata->kapasitas }}</span> 
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                    Lokasi
                                                                    </th>
                                                                    <td>
                                                                        
                                                                        <iframe style="height: 425px; width: 100%; position: relative; overflow: hidden;" src="https://maps.google.com/maps?q={{$wisata->latitude}},{{$wisata->longitude}}&output=embed"></iframe>
                                    
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                            
                            </div>
                        </div>
                    </div>
                </div>
            </section>
         @endif
         

    </div>
@endSection
@push('css')
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@push('js')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatables-demo.js') }}"></script>

@endpush