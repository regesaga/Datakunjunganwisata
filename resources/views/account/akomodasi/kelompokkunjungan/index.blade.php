@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelompok Kunjungan</li>
            </ol>
            
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("account.akomodasi.kelompokkunjungan.create") }}">
                    Tambah Nama Kelompok 
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover">
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
                            @foreach($kelompokKunjungan as $key => $kelompokkunjungan)
                                <tr data-entry-id="{{ $kelompokkunjungan->id }}">
                                
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        {{ $kelompokkunjungan->kelompokkunjungan_name ?? '' }}
                                    </td>
                                    <td>
                                        @can('kelompokkunjungan_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('account.akomodasi.kelompokkunjungan.show', $kelompokkunjungan->id) }}">
                                                {{ trans('view') }}
                                            </a>
                                        @endcan
                                            <a class="btn btn-xs btn-info" href="{{ route('account.akomodasi.kelompokkunjungan.edit', $hash->encodeHex($kelompokkunjungan->id)) }}">
                                                Ubah
                                            </a>

                                            <form action="{{ route('account.akomodasi.kelompokkunjungan.destroy', $kelompokkunjungan->id) }}" method="POST" onsubmit="return confirm('{{ trans('areYouSure') }}');" style="display: inline-block;">
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

</script>
@endsection