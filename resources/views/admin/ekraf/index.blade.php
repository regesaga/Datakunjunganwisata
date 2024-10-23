@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Ekraf</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">

<div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("admin.ekraf.create") }}">
                    {{ trans('Tambah Pelaku Ekraf') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-ekraf">
                        <thead>
                            <tr>
                                <th>
                                    Pilih
                                </th>
                                <th>
                                    No
                                </th>
                               
                                <th>
                                    Nama Pelaku Ekraf
                                </th>
                                <th>
                                    Sub Sektor Ekraf
                                </th>
                                <th>
                                    Alamat
                                </th>
                                <th>
                                    Kecamatan
                                </th>
                                <th>
                                    Telepon
                                </th>
                                <th>
                                    Instagram
                                </th>
                                <th>
                                    Photo
                                </th>
                               
                                <th>
                                    Deskripsi
                                </th>
                                
                                <th>
                                    Status
                                </th>
                                <th>
                                    Melihat
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ekrafs as $key => $ekraf)
                                <tr data-entry-id="{{ $ekraf->id }}" >
                                    <td>
                                    
                                    </td>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    
                                    <td>
                                        {{ $ekraf->namaekraf ?? '' }}
                                    </td>
                                    <td>
                                        {{ $ekraf->getSektor->sektor_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $ekraf->alamat ?? '' }}
                                    </td>
                                    <td>
                                        {{ $ekraf->kecamatan->Kecamatan ?? '' }}
                                    </td>
                                   
                                    <td>
                                        <span class="badge badge-primary">{{ $ekraf->telpon }}</span>
                                    </td>
                                    <td>
                                        {{ $ekraf->instagram ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($ekraf->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                        {!! $ekraf->deskripsi !!}
                                    </td>
                                   
                                    <td>
                                        @if($ekraf->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{ $ekraf->views ?? '' }}
                                    </td>
                                
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.ekraf.show', $hash->encodeHex($ekraf->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.ekraf.edit', $hash->encodeHex($ekraf->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('admin.ekraf.destroy', $hash->encodeHex($ekraf->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('Hapus') }}">
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</main>

<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ekraf.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('Tidak ada yang dipilih untuk di Hapus') }}')

        return
      }

      if (confirm('{{ trans('Anda Yakin ?') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-ekraf:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
