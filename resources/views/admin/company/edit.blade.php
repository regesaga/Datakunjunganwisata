@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Bisnis</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
        Edit
    </div>

    <div class="card-body">
        
        <form method="POST" action="{{ route('admin.company.update', $hash->encodeHex($company->id)) }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label class="required" for="user">user</label>
                <select class="form-control" name="user_id" value="{{ $company->user_id }}" required>
                    <option value="{{$company->user_id}}"  {{ $company->user_id!= "" ? 'selected' : '' }}>{{$company->user->name}}</option>
                    @foreach($user as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('user_id') }}
                </div>
            @endif
               
            </div>
            <div class="form-group">
                <label class="required" for="nama">Nama Pemilik</label>
                <input class="form-control" type="text" name="nama" id="nama" value="{{ $company->nama }}" required>
                @if($errors->has('nama'))
                <div class="invalid-feedback">
                    {{ $errors->first('nama') }}
                </div>
            @endif
            </div>
            <div class="form-group">
                <label class="required" for="title">Titel</label>
                <input class="form-control" type="text" name="title" id="title" value="{{ $company->title }}" required>
                @if($errors->has('title'))
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
            @endif
            </div>
            <div class="form-group">
                <label class="required" for="ijin">Ijin Usaha Sebagai</label>
                <input class="form-control" type="text" name="ijin" id="ijin" value="{{ $company->ijin }}" required>
                @if($errors->has('ijijn'))
                <div class="invalid-feedback">
                    {{ $errors->first('ijijn') }}
                </div>
            @endif
            </div>
            <div class="form-group">
                <label class="required" for="phone">telpon Penanggung Jawab</label>
                <input class="form-control" type="text" name="phone" id="phone" value="{{ $company->phone }}" required>
                @if($errors->has('phone'))
                <div class="invalid-feedback">
                    {{ $errors->first('phone') }}
                </div>
            @endif
            </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">
                    {{ trans('Simpan') }}
                </button>
        </form>
        
          
            <div class="form-group">
              
                <a class="btn btn-default" href="{{ route('admin.company.index') }}">
                  back to list
                </a>    
            </div>


    </div>
</div>
        </div>
    </div>
</main>
@endsection