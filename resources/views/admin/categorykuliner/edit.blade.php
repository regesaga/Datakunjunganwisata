@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Kuliner</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
        Edit
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.categorykuliner.update', $hash->encodeHex($category->id)) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Jenis Kuliner</label>
                <input class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}" type="text" name="category_name" id="category_name" value="{{ $category->category_name}}" required>
               
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