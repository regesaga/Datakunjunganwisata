@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Guide</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-lg-12" >
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("admin.paketwisata.create") }}">
                    {{ trans('Tambah PaketWisata') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-paketwisata">
                        <thead>
                            <tr>
                                <th width="10">
                                    Pilih
                                </th>
                               
                                <th>
                                    Nama Paket Wisata
                                </th>
                                <th>
                                    Kegiatan
                                </th>
                                
                                <th>
                                    Harga Paket
                                </th>
                                <th>
                                    Tiket termasuk
                                </th>
                                <th>
                                   Tiket Tidak termasuk
                                </th>
                               
                                <th>
                                    Photo
                                </th>
                                <th>
                                    Destinasi
                                 </th>
                               
                                <th>
                                    CP
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
                            @foreach($paketwisata as $key => $paketwisata)
                                <tr data-entry-id="{{ $paketwisata->id }}" >
                                    <td>
                                    </td>
                                    
                                    <td>
                                        {{ $paketwisata->namapaketwisata ?? '' }}
                                    </td>
                                   
                                    <td>
                                        {!! $paketwisata->kegiatan !!}
                                    </td>
                                   
                                    <td>
                                        @foreach($paketwisata->htpaketwisata as $key => $htpaketwisata)
                                       <span class="badge badge-info ">  {{ $htpaketwisata->jenis }}  Rp. {{ number_format($htpaketwisata->harga, 0, ".", ".") }},-</span>
                                    @endforeach
                                    </td>
                                   
                                    <td>
                                        {!! $paketwisata->htm !!}
                                    </td>
                                    <td>
                                        {!! $paketwisata->nohtm !!}
                                    </td>
                                    <td>
                                        @foreach($paketwisata->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    <td>
                                        {!! $paketwisata->destinasiwisata !!}
                                    </td>
                                    
                                  
                                    <td>
                                        <span class="badge badge-success">{{$paketwisata->telpon }}</span> 
                                    </td>
                                    <td>
                                        @if($paketwisata->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{ $paketwisata->views }}
                                    </td>
                                
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.paketwisata.show', $hash->encodeHex($paketwisata->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.paketwisata.edit', $hash->encodeHex($paketwisata->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('admin.paketwisata.destroy', $hash->encodeHex($paketwisata->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('admin.paketwisata.massDestroy') }}",
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
  $('.datatable-paketwisata:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
