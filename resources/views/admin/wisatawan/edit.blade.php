@extends('layouts.admin.admin')
@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Wisatawan</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header">
                        Edit
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.wisatawans.update', $hash->encodeHex($data->id)) }}">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" placeholder="Name" value="{{ $data->name }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Phone:</strong>
                                        <input type="number" name="phone" placeholder="Phone" value="{{ $data->phone }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <input type="text" name="email" placeholder="Email" value="{{ $data->email }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Password:</strong>
                                        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Confirm Password:</strong>
                                        <input id="confirm-password" type="password" placeholder="Password(Repeat)" class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" value="{{ old('confirm-password') }}">
                                        @error('confirm-password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
        
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.wisatawans.index') }}">
                                back to list
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
