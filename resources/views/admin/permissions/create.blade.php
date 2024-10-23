@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Permissions</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
       create permission
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.permissions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">permission</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
               
            </div>
            <div class="form-group">
                <label class="required" for="name">guard name</label>
                <input class="form-control {{ $errors->has('guard_name') ? 'is-invalid' : '' }}" type="text" name="guard_name" id="guard_name" value="{{ old('guard_name', '') }}" required>
               
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    save
                </button>
            </div>
        </form>
        <a class="btn btn-default" href="{{ route('admin.permissions.index') }}">
            Back to list
         </a>

    </div>
</div>
        </div>
    </div>
</main>
@endsection