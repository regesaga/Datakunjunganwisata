@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Wisata</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
        Tambah Category Wisata
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.categorywisata.storecategorywisata") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">Jenis Wisata</label>
                <input class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}" type="text" name="category_name" id="category_name" value="{{ old('category_name', '') }}" required>
                @if($errors->has('category_name'))
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