@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
<div class="card">
    <div style="text-align: center; text-transform: uppercase;" class="card-header">
        Tambah Negara
    </div>

    <div class="card-body">
        
        <form method="POST" action="{{ route("admin.wismannegara.storewismannegara") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label style="text-align: center; text-transform: uppercase;" class="required" for="name">Nama Negara</label>
                <input style="text-center: left; text-transform: uppercase;" class="form-control {{ $errors->has('wismannegara_name') ? 'is-invalid' : '' }}" type="text" name="wismannegara_name" id="wismannegara_name" value="{{ old('wismannegara_name', '') }}" required>
                @if($errors->has('wismannegara_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
               
            </div>
            <div class="form-group">
                <button style="text-align: center; text-transform: uppercase;" class="btn btn-outline-danger" type="submit">
                    Simpan
                </button>
            </div>
        </form>


    </div>
</div>
</div>
</section>
@endsection