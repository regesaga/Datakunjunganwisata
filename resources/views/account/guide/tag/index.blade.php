@extends('layouts.author.account')
@section('content')

<div class="col-lg-12">
    <div class="card">
            <!-- Page Heading -->
            
            <div class="card-body">
                <a href="{{ route("account.guide.tag.create") }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Tag</a>

                {{-- table --}}
                <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-tag">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tag as $tag)
                                    <tr>
                                    <th scope="tag">{{$loop->iteration}}</th>
                                    <td>{{$tag->nama}}</td>
                                    <td>{{$tag->slug}}</td>
                                    <td width="20%">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-info" href="{{ route('account.guide.tag.edit', $hash->encodeHex($tag->id)) }}">
                                                <i class="fas fa-edit"></i> Edit</a>

                                            <form action="{{ route('account.guide.tag.destroy', $hash->encodeHex($tag->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
@push('scripts')
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "",
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
@endpush
@endsection