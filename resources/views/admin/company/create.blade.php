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
                    create
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("admin.company.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="user">user</label>
                            <select class="form-control" name="user_id" value="{{ old('user_id') }}" required>
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
                            <input class="form-control" type="text" name="nama" id="nama" value="{{ old('nama', '') }}" required>
                            @if($errors->has('nama'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nama') }}
                            </div>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">Titel</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                            @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="ijin">Ijin Usaha Sebagai</label>
                            <input class="form-control" type="text" name="ijin" id="ijin" value="{{ old('ijin', '') }}" required>
                            @if($errors->has('ijijn'))
                            <div class="invalid-feedback">
                                {{ $errors->first('ijijn') }}
                            </div>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone">telpon Penanggung Jawab</label>
                            <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                            @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
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