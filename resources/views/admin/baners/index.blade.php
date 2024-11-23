@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Baner</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-lg-12" >
    <div class="card" >
            <!-- Page Heading -->
            
            <div class="card-body">
                <a class="btn btn-outline-success btn-sm" href="{{ route("admin.baners.create") }}">
                    <i class="fas fa-plus"></i>     {{ trans('Tambah Baner') }} 
                </a>
                <table class=" table table-bordered table-striped table-hover datatable datatable-baners">
                                <thead>
                                    <tr>
                                    <th >Pilih</th>
                                    <th scope="col">No</th>
                                    <th scope="col">Sampul</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banner as $banner)
                                    <tr data-entry-id="{{ $banner->id }}">
                                        <td ></td>
                                        <td scope="banner">{{$loop->iteration}}</td>
                                        <td><img src="/upload/banner/{{$banner->sampul}}" alt="" width="80px" height="80px"></td>
                                        <td>{{$banner->judul}}</td>
                                        <td width="25%">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-outline-success btn-sm" href="{{ route('admin.baners.show', $hash->encodeHex($banner->id)) }}"><i class="fas fa-eye"></i>
                                                    Detail</a>
                                                <a class="btn btn-info" href="{{ route('admin.baners.edit', $hash->encodeHex($banner->id)) }}">
                                                    <i class="fas fa-edit"></i> Edit</a>

                                                <form action="{{ route('admin.baners.destroy', $hash->encodeHex($banner->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-outline-danger" value="{{ trans('Hapus') }}">
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
</main>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.baners.massDestroy') }}",
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
  $('.datatable-baners:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
