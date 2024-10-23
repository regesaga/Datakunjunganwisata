@extends('layouts.admin.admin')
@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Users</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            list user
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                                    <thead>
                                        <tr>
                                            <th>

                                            </th>
                                            <th>
                                                No
                                            </th>
                                            <th>
                                                name
                                            </th>
                                            <th>
                                                Phone
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
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wisatawan as $key => $data)
                                            <tr data-entry-id="{{ $data->id }}">
                                                <td>

                                                </td>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $data->name ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $data->phone ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $data->email ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $data->created_at ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $data->updated_at ?? '' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" aria-label="Basic example">
                                                        <a class="btn btn-xs btn-primary"
                                                            href="{{ route('admin.wisatawans.show', $hash->encodeHex($data->id)) }}">
                                                            Detail
                                                        </a>
                                                        <a class="btn btn-xs btn-info"
                                                            href="{{ route('admin.wisatawans.edit', $hash->encodeHex($data->id)) }}">
                                                            Edit
                                                        </a>


                                                        <form
                                                            action="{{ route('admin.wisatawans.destroy', $hash->encodeHex($data->id)) }}"
                                                            method="POST" onsubmit="return confirmstyle: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger"
                                                                value="delete">
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
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.admin.users.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.Tidak ada yang dipilih untuk di Hapus') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            $('.datatable-User:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
