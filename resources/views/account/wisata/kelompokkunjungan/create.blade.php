@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<div class="container">
<div class="card">
    <div class="card-header">
        Tambah Kelompok
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("account.wisata.kelompokkunjungan.storekelompokkunjungan") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">Nama Kelompok</label>
                <input class="form-control {{ $errors->has('kelompokkunjungan_name') ? 'is-invalid' : '' }}" type="text" name="kelompokkunjungan_name" id="kelompokkunjungan_name" value="{{ old('kelompokkunjungan_name', '') }}" required>
                @if($errors->has('kelompokkunjungan_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
               
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