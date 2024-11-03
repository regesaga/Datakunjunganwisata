@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<div class="container">
<div class="card">
    <div class="card-header">
        Ubah Fasilitas
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('account.wisata.kelompokkunjungan.update', $hash->encodeHex($kelompokKunjungan->id)) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Nama</label>
                <input class="form-control" type="text" name="kelompokkunjungan_name" id="name" value=" {{$kelompokKunjungan->kelompokkunjungan_name }}" required>
                
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Simpan
                </button>
            </div>
        </form>


    </div>
</div>
</div>
@endsection
