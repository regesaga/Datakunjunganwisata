@extends('layouts.author.account')
@section('content')
<div class="card-header">
        Edit Baner Promo
    </div>

    <div class="card-body">
<div class="col-12">
    <div class="card">
        <div class="card-header">
    <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Baner Promo</h1>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("account.ekraf.banerpromo.update", $hash->encodeHex($banerpromo->id)) }}"   enctype="multipart/form-data" >
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <img src="/upload/banerpromo/{{$banerpromo->sampul}}" width="150px" height="150px" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul') ? old('judul') : $banerpromo->judul}}">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="sampul">Sampul</label><small class="text-warning">Pastikann Ukuran Baner Promo 1074 x 258 px</small>
                            <input type="file" class="form-control" id="sampul" name="sampul">
                            @error('sampul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                       
                    </div>
                </div>
                <a href="{{ route('account.ekraf.banerpromo.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                
            </form>

        </div>
    </div>
</div>
    </div>
    @endsection
