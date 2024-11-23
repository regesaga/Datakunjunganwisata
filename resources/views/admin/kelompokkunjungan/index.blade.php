@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
            <ol class="breadcrumb">
                <li style="text-align: center; text-transform: uppercase;" class="breadcrumb-item active">Kelompok Kunjungan</li>
            </ol>
            
        <div class="card">
            <div class="card-header">
                <a style="text-align: center; text-transform: uppercase;" class="btn btn-outline-success btn-sm" href="{{ route("admin.kelompokkunjungan.create") }}">
                    Tambah Nama Kelompok 
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    
                    <table  class="table table-bordered table-striped">
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
                            @foreach($kelompokKunjungan as $key => $kelompokkunjungan)
                                <tr data-entry-id="{{ $kelompokkunjungan->id }}">
                                
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{$loop->iteration}}
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        {{ $kelompokkunjungan->kelompokkunjungan_name ?? '' }}
                                    </td>
                                    <td style="text-align: center; text-transform: uppercase;">
                                        @can('kelompokkunjungan_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.kelompokkunjungan.show', $kelompokkunjungan->id) }}">
                                                {{ trans('view') }}
                                            </a>
                                        @endcan
                                            <a style="text-align: center; text-transform: uppercase;" class="btn btn-xs btn-info" href="{{ route('admin.kelompokkunjungan.edit', $hash->encodeHex($kelompokkunjungan->id)) }}">
                                                Ubah
                                            </a>

                                            <form action="{{ route('admin.kelompokkunjungan.destroy',$hash->encodeHex($kelompokkunjungan->id)) }}" method="POST" onsubmit="return confirm('{{ trans('Apakah Anda Yakin ?') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input  style="text-align: center; text-transform: uppercase;"type="submit" class="btn btn-xs btn-danger" value="{{ trans('Delete') }}">
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

</script>
@endsection