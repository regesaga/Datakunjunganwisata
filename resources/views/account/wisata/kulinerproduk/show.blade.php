@extends('layouts.author.account')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Detail Produk Kuliner  
            </div>
           

            <div class="card-body">
                <div class="form-group">
                    
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-ShowWisata">
                        <tbody>
                            <tr>
                                <th>
                                    Nama Kuliner
                                </th>
                                <td>
                                    {{ $kulinerproduk->kuliner->namakuliner }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Produk
                                </th>
                                <td>
                                    {{ $kulinerproduk->nama ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Deskripsi
                                </th>
                                <td>
                                    {!! $kulinerproduk->deskripsi !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    @if($kulinerproduk->active == 1)
                                    <span class="badge badge-success ">Sedia</span>
                                @else
                                <span class="badge badge-secondary ">Tidak Sedia</span>
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Melihat
                                </th>
                                <td>
                                    {{ $kulinerproduk->views }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Harga
                                </th>
                                <td>
                                    <span class="badge badge-info ">  Rp. {{ number_format($kulinerproduk->harga, 0, ".", ".") }},-</span>
                                </td>
                            </tr>
                          
                            <tr>
                                <th>
                                    Photo
                                </th>
                                <td>
                                    @foreach($kulinerproduk->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('account.wisata.kulinerproduk.index') }}">
                            Kembali
                        </a>
                        <a class="btn btn-outline-primary" href="{{ route('account.wisata.kulinerproduk.edit', $hash->encodeHex($kulinerproduk->id)) }}">
                            Edit  
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endSection