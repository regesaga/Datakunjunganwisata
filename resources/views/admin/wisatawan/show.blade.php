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
                        show wisatawan detail
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.wisatawans.index') }}">
                                back to list
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Id
                                    </th>
                                    <td>
                                        {{ $data->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <td>
                                        {{ $data->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Phone
                                    </th>
                                    <td>
                                        {{ $data->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Email
                                    </th>
                                    <td>
                                        {{ $data->email }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a class="btn btn-default" href="{{ route('admin.wisatawans.index') }}">
                        back to list
                    </a>
                    <a class="btn btn-info" href="{{ route('admin.wisatawans.edit', $hash->encodeHex($data->id)) }}">
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
