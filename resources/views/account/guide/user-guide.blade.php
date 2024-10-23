@extends('layouts.author.account')

@section('content')
    <div class="account-bdy p-3">
        <div class="row mb-3">
            <div class="col-xl-6 col-sm-6 py-2">
                <a href="{{ route('account.guide.article.index') }}">
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
          
            <div class="col-xl-6 col-sm-6 py-2">
              <a href="{{ route('account.guide.banerpromo.index') }}">
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
                            <a href="{{route('account.guide.company.create')}}" class="btn primary-btn mr-2">Isi Detail Perusahaan</a>
                            @else
                            <a href="{{route('account.guide.company.edit')}}" class="btn secondary-btn mr-2">Edit Perusahaan</a>
                            
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
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{route('account.guide.guide.create')}}">
                    {{ trans('Tambah PaketWisata') }} 
                </a>
            </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-guide">
                    <thead>
                        <tr>
                            <th>
                               No
                            </th>
                           
                            <th>
                                Nama Paket Wisata
                            </th>
                            <th>
                                Kegiatan
                            </th>
                            
                            <th>
                                Harga Paket
                            </th>
                            <th>
                                Tiket termasuk
                            </th>
                            <th>
                               Tiket Tidak termasuk
                            </th>
                           
                            <th>
                                Photo
                            </th>
                            <th>
                                Destinasi
                             </th>
                           
                            <th>
                                CP
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Melihat
                            </th>
                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guide as $key => $guide)
                        <tr>
                        <td>{{ $loop->iteration }}</td>
                                
                                <td>
                                    {{ $guide->namapaketwisata ?? '' }}
                                </td>
                               
                                <td>
                                    {!! $guide->kegiatan !!}
                                </td>
                               
                                <td>
                                    @foreach($guide->htpaketwisata as $key => $htpaketwisata)
                                   <span class="badge badge-info ">  {{ $htpaketwisata->jenis }}  Rp. {{ number_format($htpaketwisata->harga, 0, ".", ".") }},-,</span>
                                @endforeach
                                </td>
                               
                                <td>
                                    {!! $guide->htm !!}
                                </td>
                                <td>
                                    {!! $guide->nohtm !!}
                                </td>
                                <td>
                                    @foreach($guide->photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endforeach
                                </td>
                                <td>
                                    {!! $guide->destinasiwisata !!}
                                </td>
                                
                              
                                <td>
                                    <span class="badge badge-success">{{$guide->telpon }}</span> 
                                </td>
                                <td>
                                    @if($guide->active == 1)
                                    <span class="badge badge-success ">Publish</span>
                                @else
                                <span class="badge badge-secondary ">Draft</span>
                                @endif
                                </td>
                                <td>
                                    {{ $guide->views }}
                                </td>
                            
                                
                                <td>
                                    <div class="btn-group" aria-label="Basic example">
                                        <a class="btn btn-xs btn-primary" href="{{ route('account.guide.guide.show', $hash->encodeHex($guide->id)) }}">
                                            Detail
                                        </a>

                                        <a class="btn btn-xs btn-info" href="{{ route('account.guide.guide.edit', $hash->encodeHex($guide->id)) }}">
                                            Edit  
                                        </a>

                                        <form action="{{ route('account.guide.guide.destroyguide', $hash->encodeHex($guide->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('Hapus') }}">
                                        </form>
                                    </div>
                                </td>
                        </tr>
                            @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        </div>
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