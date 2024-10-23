@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Produk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("admin.kulinerproduk.create") }}">
                    {{ trans('Tambah Produk') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-kulinerproduk">
                        <thead>
                            <tr>
                                <th width="10">
                                    Pilih
                                </th>
                                <th>
                                   No.
                                </th>
                                

                                <th>
                                    Nama Kuliner
                                </th>
                                <th>
                                    Nama Produk
                                </th>
                                
                                <th>
                                    Deskripsi
                                </th>
                                <th>
                                    Harga
                                </th>
                              
                                
                                <th>
                                    Status 
                                </th>
                                <th>
                                    Melihat 
                                </th>
                                <th>
                                    Photo
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kulinerproduks as $key => $kulinerproduk)
                                <tr data-entry-id="{{ $kulinerproduk->id }}" >
                                    <td>
                                        <th>{{$loop->iteration}}</th>
                                    </td>
                                    
                                    <td>
                                        {{ $kulinerproduk->kuliner->namakuliner ?? '' }}
                                    </td>
                                    <td>
                                        {{ $kulinerproduk->nama  }}
                                    </td>
                                   
                                    <td>
                                        {!! $kulinerproduk->deskripsi !!}
                                    </td>
                                    <td>
                                        <span class="badge badge-info "> Rp. {{ number_format($kulinerproduk->harga, 0, ".", ".") }},-</span>
                                    </td>
                                  
                                    <td>
                                        @if($kulinerproduk->active == 1)
                                        <span class="badge badge-success ">Tersedia</span>
                                    @else
                                    <span class="badge badge-secondary ">Tidak Sedia</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{ $kulinerproduk->views}}
                                    </td>
                                   
                                    <td>
                                        @foreach($kulinerproduk->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.kulinerproduk.show', $hash->encodeHex($kulinerproduk->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.kulinerproduk.edit', $hash->encodeHex($kulinerproduk->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('admin.kulinerproduk.destroy', $hash->encodeHex($kulinerproduk->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('admin.kulinerproduk.massDestroy') }}",
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
  $('.datatable-kulinerproduk:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
