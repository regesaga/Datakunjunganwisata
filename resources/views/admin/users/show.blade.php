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
       show user detail
    </div>

    <div class="card-body">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    back to list
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            id
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            name
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            email
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            email_verified_at
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            roles
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="badge badge-info">{{ $roles->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Profile Usaha</th>
                        <td>
                            @if ($user->company)
                                {{ $user->company->nama }}
                            @else
                                Data Perusahaan Tidak Tersedia
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <th>
                            Jenis Usaha
                        </th>
                        <td>
                            @if ($user->company)
                                {{ $user->company->title }}
                            @else
                                Data Perusahaan Tidak Tersedia
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
         </div>
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                  back to list
                </a>
                <a class="btn btn-info" href="{{ route('admin.users.edit', $hash->encodeHex($user->id)) }}">
                    Edit  
                </a>
</div>
        </div>
    </div>
</main>
@endsection