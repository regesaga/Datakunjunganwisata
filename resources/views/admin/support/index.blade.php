@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Support</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-lg-12" >
    <div class="card" >
            <!-- Page Heading -->
            
            <div class="card-body">
                <a class="btn btn-success" href="{{ route("admin.support.create") }}">
                    <i class="fas fa-plus"></i>     {{ trans('Tambah Support') }} 
                </a>
                <table class=" table table-bordered table-striped table-hover datatable datatable-support">
                                <thead>
                                    <tr>
                                    <th>Pilih</th>
                                    <th scope="col">No</th>
                                    <th scope="col">Sampul</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($support as $support)
                                    <tr data-entry-id="{{ $support->id }}">
                                        <td ></td>
                                        <td scope="support">{{$loop->iteration}}</td>
                                        <td><img src="/upload/support/{{$support->sampul}}" alt="" width="80px" height="80px"></td>
                                        <td>{{$support->judul}}</td>
                                        <td width="25%">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-info" href="{{ route('admin.support.edit', $hash->encodeHex($support->id)) }}">
                                                    <i class="fas fa-edit"></i> Edit</a>

                                                <form action="{{ route('admin.support.destroy', $hash->encodeHex($support->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-danger" value="{{ trans('Hapus') }}">
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
    url: "{{ route('admin.support.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('Tidak ada yang dipilih untuk di Hapus') }}')

        return
      }

      if (confirm('{{ trans('areYouSure') }}')) {
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
  $('.datatable-support:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>