@extends('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Akomodasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.categoryakomodasi.create") }}">
                Tambah Jenis Akomodasi
            </a>
    
            <div class="card">
                <div class="card-header">
                List Jenis Akomodasi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Category">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                    id
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
                                @foreach($categories as $key => $category)
                                    <tr data-entry-id="{{ $category->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{ $category->category_name ?? '' }}
                                        </td>
                                        <td>
                                            @can('category_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.categoryakomodasi.show', $category->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.categoryakomodasi.edit', $hash->encodeHex($category->id)) }} ">
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.categoryakomodasi.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ trans('areYouSure') }}');" style="display: inline-block;">
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
        </div>
    </div>
</main>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('Delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.categoryakomodasi.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.Tidak ada yang dipilih untuk di Hapus') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
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
  $('.datatable-Category:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection