@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Rools</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
       create
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.roles.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                
            </div>
            <div class="form-group">
                <label class="required" for="name">guard name</label>
                <input class="form-control {{ $errors->has('guard_name') ? 'is-invalid' : '' }}" type="text" name="guard_name" id="guard_name" value="{{ old('guard_name', '') }}" required>
                
            </div>
            <div class="form-group">
                <label class="required" for="permissions">permission</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required>
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ in_array($id, old('permissions', [])) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>
               
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    save
                </button>
            </div>
        </form>


    </div>
</div>
        </div>
    </div>
</main>
@endsection