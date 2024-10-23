@extends('layouts.author.account')

@section('content')
  <div class="account-layout  border">
    <div class="account-bdy p-3">
        @if($akomodasi)
        <div class="row mb-3">
            <div class="col-xl-3 col-sm-6 py-2">
              <a href="{{ route('account.wisata.banerpromo.index') }}">
                <div class="card dashboard-card text-white h-100 shadow">
                    <div class="card-body primary-bg">
                        <div class="rotate">
                            <i class="fas fa-users fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Baner Promo</h6>
                        <h1 class=""></h1>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
              @if($akomodasi)
              <a href="{{ route('account.wisata.room.index') }}">
                  @else
              <a href="">
                  @endif
                <div class="card dashboard-card text-white  h-100 shadow">
                    <div class="card-body bg-info">
                        <div class="rotate">
                            <i class="fas fa-th fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">KAMAR</h6>
                        @if($akomodasi)
                        <h1 class="">{{$dashCount['room']}}</h1>
                        @else
                        <h1 class="">0</h1>
                        @endif
  
                    </div>
                </div>
              </a>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
              <a href="{{ route('account.wisata.even.index') }}">
                <div class="card dashboard-card text-white h-100 shadow">
                    <div class="card-body bg-warning">
                        <div class="rotate">
                            <i class="fas fa-file fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Even</h6>
                        <h1 class=""></h1>
                    </div>
                </div>
              </a>
              </div>
            <div class="col-xl-3 col-sm-6 py-2">
                <a href="{{ route('account.wisata.reserv') }}">
                  <div class="card dashboard-card text-white h-100 shadow">
                      <div class="card-body bg-danger">
                          <div class="rotate">
                              <i class="fas fa-envelope fa-4x"></i>
                          </div>
                          <h6 class="text-uppercase">Reservasi</h6>
                          <h1 class=""></h1>
                      </div>
                  </div>
                </a>
            </div>
        </div>
      @endif

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
                                      <table class=" table table-bordered table-striped table-hover datatable datatable-ShowAkomodasi">
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
                      <h4 class="card-title">Kelola Detail Akomodasi</h4>
                      
                      <div class="mb-3 d-flex">
                          @if(!$akomodasi)
                          <a href="{{route('account.wisata.akomodasi.create')}}" class="btn primary-btn mr-2">Isi Detail Akomodasi</a>
                      @else
                          <a href="{{route('account.wisata.akomodasi.edit')}}" class="btn secondary-btn mr-2">Edit Akomodasi</a>
                      @endif
                      </div>
                      @if($akomodasi)
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class=" table table-bordered table-striped table-hover datatable datatable-ShowAkomodasi">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        Nama Akomodasi
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->namaakomodasi }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Kategori Akomodasi
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->getCategoryAkomodasi->category_name ?? '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Alamat
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->alamat }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Kecamatan
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->kecamatan->Kecamatan}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <td>
                                                        @if($akomodasi->active == 1)
                                                        <span class="badge badge-success ">Publish</span>
                                                    @else
                                                    <span class="badge badge-secondary ">Draft</span>
                                                    @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <i class="ri-eye-fill"></i>{{ __('messages.webView') }} 
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->views }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Deskripsi
                                                    </th>
                                                    <td>
                                                        {!! $akomodasi->deskripsi !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Photo
                                                    </th>
                                                    <td>
                                                        @foreach($akomodasi->photos as $key => $media)
                                                            <a href="!!{ $media->getUrl() }}" target="_blank">
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
                                                        @foreach($akomodasi->fasilitas as $key => $fasilitas)
                                                        <span class="badge badge-primary">{{ $fasilitas->fasilitas_name }}</span>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Instagram
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->instagram }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Web
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->web }}
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Telphon
                                                    </th>
                                                    <td>
                                                        <span class="badge badge-primary"><i class="fas fa-phone">&nbsp;{{ $akomodasi->telpon }}</i></span>
                                                        
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>
                                                    Jam Oprasional
                                                    </th>
                                                    <td>
                                                        {{ $akomodasi->jambuka }} S.d {{ $akomodasi->jamtutup }}
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>
                                                    Kapasitas Pengunjung
                                                    </th>
                                                    <td>
                                                        <span class="badge badge-primary">{{$akomodasi->kapasitas }}</span> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                    Lokasi
                                                    </th>
                                                    <td>
                                                        
                                                        <iframe style="height: 425px; width: 100%; position: relative; overflow: hidden;" src="https://maps.google.com/maps?q={{$akomodasi->latitude}},{{$akomodasi->longitude}}&output=embed"></iframe>
                    
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
  </div>
@endSection
@push('css')
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@push('js')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatables-demo.js') }}"></script>
<script>
    $(document).ready(function(){
        //delete author company
        $('#companyDestroyBtn').click(function(e){
            e.preventDefault();
            if(window.confirm('Are you sure you want delete the company?')){
                $('#companyDestroyForm').submit();
            }
        })
    })
</script>    
@endpush