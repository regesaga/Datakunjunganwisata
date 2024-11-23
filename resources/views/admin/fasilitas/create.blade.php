@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Fasilitas</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
        Create
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fasilitas.storefasilitas") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">Nama Fasilitas</label>
                <input class="form-control {{ $errors->has('fasilitas_name') ? 'is-invalid' : '' }}" type="text" name="fasilitas_name" id="fasilitas_name" value="{{ old('fasilitas_name', '') }}" required>
                @if($errors->has('fasilitas_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
               
            </div>
            <div class="form-group">
                <button class="btn btn-outline-danger" type="submit">
                    Simpan
                </button>
            </div>
        </form>


    </div>
</div>
        </div>
    </div>
</main>
@endsection