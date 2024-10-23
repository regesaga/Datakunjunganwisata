@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Akomodasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
        Create
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.categoryakomodasi.storecategoryakomodasi") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">Jenis Akomodasi</label>
                <input class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}" type="text" name="category_name" id="category_name" value="{{ old('category_name', '') }}" required>
               
               
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>
            </div>
        </form>


    </div>
</div>
        </div>
    </div>
</main>
@endsection