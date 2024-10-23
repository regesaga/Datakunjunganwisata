@extends('layouts.author.account')
@section('content')

<div class="col-12">
    <div class="card">
            <div class="card-header">
        <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">edit</h1>
            </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("account.guide.tag.update", $hash->encodeHex($tag->id)) }}"   enctype="multipart/form-data" >
                        @method('PUT')
                        @csrf
                            <div class="form-group">
                                <label for="nama">Tag</label><input type="text" class="form-control" id="nama" name="nama" value="{{$tag->nama}}">
                               
                            </div>
                        <button type="submit" class="btn btn-primary ">Edit</button>
                        <a href="{{ route("account.guide.tag.index") }}" class="btn btn-secondary ">Kembali</a>
                    </form>
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