@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<div class="container">
<div class="card">
    <div class="card-header">
        Tambah Negara
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("account.wisata.wismannegara.storewismannegara") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">Nama Negara</label>
                <input class="form-control {{ $errors->has('wismannegara_name') ? 'is-invalid' : '' }}" type="text" name="wismannegara_name" id="wismannegara_name" value="{{ old('wismannegara_name', '') }}" required>
                @if($errors->has('wismannegara_name'))
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