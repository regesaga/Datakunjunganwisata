@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Negara Kunjungan</li>
        </ol>
          
            <div class="card">
                        <div class="card-header">
                            <a class="btn btn-success" href="{{ route("account.akomodasi.wismannegara.create") }}">
                                Tambah Negara
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover ">
                                    <thead>
                                        <tr>
                                        
                                            <th>
                                                No
                                            </th>
                                            <th>
                                                name
                                            </th>
                                            <th>
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($wismannegara as $key => $wismannegara)
                                            <tr data-entry-id="{{ $wismannegara->id }}">
                                                
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>
                                                    {{ $wismannegara->wismannegara_name ?? '' }}
                                                </td>
                                                <td>
                                                    @can('wismannegara_show')
                                                        <a class="btn btn-xs btn-primary" href="{{ route('account.akomodasi.wismannegara.show', $wismannegara->id) }}">
                                                            {{ trans('view') }}
                                                        </a>
                                                    @endcan
                                                        <a class="btn btn-xs btn-info" href="{{ route('account.akomodasi.wismannegara.edit', $hash->encodeHex($wismannegara->id)) }}">
                                                            Ubah
                                                        </a>

                                                        <form action="{{ route('account.akomodasi.wismannegara.destroy', $wismannegara->id) }}" method="POST" onsubmit="return confirm('{{ trans('areYouSure') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('Delete') }}">
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