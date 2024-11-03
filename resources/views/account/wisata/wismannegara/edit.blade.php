@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<div class="container">
<div class="card">
    <div class="card-header">
        Ubah Negara
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('account.wisata.wismannegara.update', $hash->encodeHex($wismannegara->id)) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Nama</label>
                <input class="form-control" type="text" name="wismannegara_name" id="name" value=" {{$wismannegara->wismannegara_name }}" required>
                
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
