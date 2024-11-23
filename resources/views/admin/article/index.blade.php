@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Article</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
                <div class="col-lg-12">
                    <div class="card">
                            <!-- Page Heading -->
                            
                            <div class="card-body">
                                <a class="btn btn-outline-success btn-sm" href="{{ route("admin.article.create") }}">
                                    <i class="fas fa-plus"></i>     {{ trans('Tambah Article') }} 
                                </a>
                                <table class=" table table-bordered table-striped table-hover datatable datatable-article">
                                    <thead>
                                    <tr>
                                    <th>Pilih</th>
                                    <th>No</th>
                                    <th>Sampul</th>
                                    <th>Judul</th>
                                    <th>Tag</th>
                                    <th>Status</th>
                                    <th>Melihat</th>
                                    <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($article as $article)
                                    <tr  data-entry-id="{{ $article->id }}">
                                            <td></td>
                                        <td>{{$loop->iteration}}</td>
                                        <td><img src="/upload/article/{{$article->sampul}}" alt="" width="80px" height="80px"></td>
                                        <td>{{$article->judul}}</td>
                                        <td>
                                        @foreach ($article->tag as $tag)
                                            <span class="badge badge-secondary">{{$tag->nama}}</span>
                                        @endforeach
                                        </td>
                                        <td>
                                            @if($article->active == 1)
                                            <span class="badge badge-success ">Publish</span>
                                        @else
                                        <span class="badge badge-secondary ">Draft</span>
                                        @endif
                                        </td>
                                        <td>{{$article->views}}</td>

                                        <td width="25%">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-outline-success btn-sm" href="{{ route('admin.article.show', $hash->encodeHex($article->id)) }}"><i class="fas fa-eye"></i>
                                                    Detail</a>
                                                <a class="btn btn-info" href="{{ route('admin.article.edit', $hash->encodeHex($article->id)) }}">
                                                    <i class="fas fa-edit"></i> Edit</a>

                                                <form action="{{ route('admin.article.destroy', $hash->encodeHex($article->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('admin.article.massDestroy') }}",
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
  $('.datatable-article:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
