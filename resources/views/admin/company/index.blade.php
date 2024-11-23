@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Bisnis</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
    
        <div class="col-lg-12">
            <a class="btn btn-outline-success btn-sm" href="{{ route("admin.company.create") }}">
              tambah Pengusaha
            </a>
        
<div class="card">
    <div class="card-header">
       list Pengusaha 
    </div>

    <div class="card-body">
        <div class="table-responsive">
            @if ($company->isNotEmpty())
            <table class=" table table-bordered table-striped table-hover datatable datatable-company">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            No
                        </th>
                        <th>
                            Role
                        </th>
                        <th>
                            User
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            id
                        </th>
                        <th>
                            Pemilik
                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Ijin Sebagai
                        </th>
                        <th>
                           Contact Person 
                        </th>
                        <th>
                            created at
                        </th>
                        <th>
                            updated at
                        </th>
                       
                        <th>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($company as $key => $company)
                        <tr data-entry-id="{{ $company->id }}">
                            <td>

                            </td>
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                @if ($company->user && $company->user->roles && $company->user->roles->isNotEmpty())
                                    @foreach ($company->user->roles as $role)
                                        <span class="badge badge-info">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    Tidak ada data roles
                                @endif
                            </td>
                            
                              
                            <td>
                                {{ $company->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $company->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $company->id ?? '' }}
                            </td>
                            <td>
                                {{ $company->nama ?? '' }}
                            </td>
                            <td>
                                {{ $company->title ?? '' }}
                            </td>
                            <td>
                                {{ $company->ijin ?? '' }}
                            </td>
                            <td>
                                {{ $company->phone ?? '' }}
                            </td>
                            <td>
                                {{ $company->created_at ?? '' }}
                            </td>
                            <td>
                                {{ $company->updated_at ?? '' }}
                            </td>
                            
                            <td>
                                <div class="btn-group" aria-label="Basic example">
                               
                                <a class="btn btn-xs btn-info" href="{{ route('admin.company.edit', $hash->encodeHex($company->id)) }}">
                                    Edit  
                                </a>

                                
                                    <form action="{{ route('admin.company.destroy', $hash->encodeHex($company->id)) }}" method="POST" onsubmit="return confirmstyle: inline-block;">
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
            @else
       <p>Tidak ada data yang dapat ditampilkan.</p>
   @endif
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
    url: "{{ route('admin.company.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('Tidak ada yang dipilih untuk di Hapus') }}')

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
  $('.datatable-company:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>