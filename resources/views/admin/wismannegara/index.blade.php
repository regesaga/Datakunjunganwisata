@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li style="text-align: center; text-transform: uppercase;" class="breadcrumb-item active">Negara Kunjungan</li>
        </ol>
          
            <div class="card">
                        <div class="card-header">
                            <a style="text-align: center; text-transform: uppercase;"class="btn btn-outline-success btn-sm" href="{{ route("admin.wismannegara.create") }}">
                                Tambah Negara
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover ">
                                    <thead>
                                        <tr>
                                        
                                            <th style="text-align: center; text-transform: uppercase;">
                                                No
                                            </th>
                                            <th style="text-align: center; text-transform: uppercase;">
                                                name
                                            </th>
                                            <th style="text-align: center; text-transform: uppercase;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($wismannegara as $key => $wismannegara)
                                            <tr data-entry-id="{{ $wismannegara->id }}">
                                                
                                                <td style="text-align: center; text-transform: uppercase;">
                                                    {{$loop->iteration}}
                                                </td>
                                                <td style="text-align: center; text-transform: uppercase;">
                                                    {{ $wismannegara->wismannegara_name ?? '' }}
                                                </td>
                                                <td style="text-align: center; text-transform: uppercase;">
                                                    @can('wismannegara_show')
                                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.wismannegara.show', $wismannegara->id) }}">
                                                            {{ trans('view') }}
                                                        </a>
                                                    @endcan
                                                        <a  style="text-align: center; text-transform: uppercase;"class="btn btn-xs btn-info" href="{{ route('admin.wismannegara.edit', $hash->encodeHex($wismannegara->id)) }}">
                                                            Ubah
                                                        </a>

                                                        <form action="{{ route('admin.wismannegara.destroy',$hash->encodeHex($wismannegara->id)) }}" method="POST" onsubmit="return confirm('{{ trans('Anda Yakin?') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input style="text-align: center; text-transform: uppercase;" type="submit" class="btn btn-xs btn-danger" value="{{ trans('Delete') }}">
                                                        </form>

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
            </div>
    </div>
@endsection