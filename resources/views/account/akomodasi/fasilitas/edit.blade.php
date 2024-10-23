@extends('layouts.author.account')
@section('content')

<div class="card">
    <div class="card-header">
        Ubah Fasilitas
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('account.akomodasi.fasilitas.update', $hash->encodeHex($fasilitas->id)) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Nama</label>
                <input class="form-control" type="text" name="name" id="name" value=" {{$fasilitas->fasilitas_name }}" required>
                
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Simpan
                </button>
            </div>
        </form>


    </div>
</div>
@endsection