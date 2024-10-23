@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Users</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="card">
    <div class="card-header">
        Edit
    </div>

    <div class="card-body">
        
        <form method="POST" action="{{ route('admin.users.update', $hash->encodeHex($user->id)) }}">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Name" value="{{ $user->name }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" name="email" placeholder="Email" value="{{ $user->email }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password:</strong>
                        <input type="password" name="password" placeholder="Password" class="form-control" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Confirm Password:</strong>
                        <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Role:</strong>
                        <select name="roles" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ $role == $userRole ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        
          
            <div class="form-group">
              
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                  back to list
                </a>    
            </div>


    </div>
</div>
        </div>
    </div>
</main>
@endsection