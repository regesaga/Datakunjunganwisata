@extends('layouts.author.account')

@section('content')
  <div class="account-layout  border">
    <div class="account-bdy p-3">
        <div class="row mb-3">
            <div class="col-xl-4 col-sm-6 py-2">
                <a href="{{ route('account.ekraf.article.index') }}">
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
          <div class="col-xl-4 col-sm-6 py-2">
              <div class="card dashboard-card text-white  h-100 shadow">
                  <div class="card-body bg-info">
                      <div class="rotate">
                          <i class="fas fa-th fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Jumlah Produk</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
          </div>
          <div class="col-xl-4 col-sm-6 py-2">
              <a href="{{ route('account.ekraf.banerpromo.index') }}">
                <div class="card dashboard-card text-white h-100 shadow">
                    <div class="card-body bg-danger">
                        <div class="rotate">
                            <i class="fas fa-envelope fa-4x"></i>
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
                          <a href="{{route('account.ekraf.company.create')}}" class="btn primary-btn mr-2">Isi Detail Perusahaan</a>
                          @else
                          <a href="{{route('account.ekraf.company.edit')}}" class="btn secondary-btn mr-2">Edit Perusahaan</a>
                          
                          @endif
                        </div>
                        @if($company)
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="card">
                                  <div class="table-responsive">
                                      <table class=" table table-bordered table-striped table-hover datatable datatable-ShowEkraf">
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
                      <h4 class="card-title">Kelola Detail Ekraf</h4>
                      
                      <div class="mb-3 d-flex">
                          @if(!$ekraf)
                          <a href="{{route('account.ekraf.ekraf.create')}}" class="btn primary-btn mr-2">Isi Detail Ekraf</a>
                      @else
                          <a href="{{route('account.ekraf.ekraf.edit')}}" class="btn secondary-btn mr-2">Edit Ekraf</a>
                      @endif
                      </div>
                      @if($ekraf)
                      <div class="row">
                          <div class="col-sm-12 col-md-12">
                              <div class="card">
                                  <div class="table-responsive">
                                      <table class=" table table-bordered table-striped table-hover datatable datatable-ShowEkraf">
                                      <tbody>
                                        <tr>
                                            <th>
                                                Nama Pelaku Ekonomi Kreatif
                                            </th>
                                            <td>
                                                {{ $ekraf->namaekraf }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Sub Sektor
                                            </th>
                                            <td>
                                                {{ $ekraf->getSektor->sektor_name ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Alamat
                                            </th>
                                            <td>
                                                {{ $ekraf->alamat }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Kecamatan
                                            </th>
                                            <td>
                                                {{ $ekraf->kecamatan->Kecamatan}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Status
                                            </th>
                                            <td>
                                                @if($ekraf->active == 1)
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
                                                {{ $ekraf->views }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Deskripsi
                                            </th>
                                            <td>
                                                {!! $ekraf->deskripsi !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Photo
                                            </th>
                                            <td>
                                                @foreach($ekraf->photos as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                                    </a>
                                                @endforeach
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>
                                                Instagram
                                            </th>
                                            <td>
                                                {{ $ekraf->instagram }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Web
                                            </th>
                                            <td>
                                                {{ $ekraf->web }}
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Telphon
                                            </th>
                                            <td>
                                                {{ $ekraf->telpon }}
                                                
                                            </td>
                                        </tr>
                                        
                                        
                                       
                                       
                                        <tr>
                                            <th>
                                            Lokasi
                                            </th>
                                            <td>
                                                
                                                <iframe style="height: 425px; width: 100%; position: relative; overflow: hidden;" src="https://maps.google.com/maps?q={{$ekraf->latitude}},{{$ekraf->longitude}}&output=embed"></iframe>
            
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
 
@endpush