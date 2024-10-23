@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Users</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                tambah user
                </a>
            
                <div class="card">
                    <div class="card-header">
                    list user
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-user">
                                <thead>
                                    <tr>
                                        <th>
                                            Pilih
                                        </th>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            name
                                        </th>
                                        <th>
                                            email
                                        </th>
                                        <th>
                                            created at
                                        </th>
                                        <th>
                                            updated at
                                        </th>
                                        <th>
                                            roles
                                        </th>
                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                        <tr data-entry-id="{{ $user->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{ $user->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->email ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->created_at ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->updated_at ?? '' }}
                                            </td>
                                            <td>
                                                @foreach($user->roles as $key => $item)
                                                    <span class="badge badge-success">{{ $item->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="btn-group" aria-label="Basic example">
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $hash->encodeHex($user->id)) }}">
                                                    Detail
                                                </a>
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $hash->encodeHex($user->id)) }}">
                                                    Edit  
                                                </a>

                                                
                                                    <form action="{{ route('admin.users.destroy', $hash->encodeHex($user->id)) }}" method="POST" onsubmit="return confirmstyle: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger" value="delete">    
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
    url: "{{ route('admin.users.massDestroy') }}",
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
  $('.datatable-user:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>