@extends('layouts.author.account')
@section('content')
<div class="card-header">
        Tambah Baner Promo
    </div>

    <div class="card-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('account.ekraf.banerpromo.store')}}"  method="post" enctype="multipart/form-data" >
                            @csrf
                            
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul')}}">
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
                                    
                    
                               
                                
                                <a  href="{{ route('account.ekraf.banerpromo.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
</div>
            @endsection
