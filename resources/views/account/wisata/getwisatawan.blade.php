@extends('layouts.author.account')

@section('content')
    <div class="account-bdy p-3">
        <div class="row mb-3">
            <div class="col-xl-2 col-sm-6 py-2">
                <a href="{{ route('account.wisata.tiketwisata') }}">
                  <div class="card dashboard-card text-white h-100 shadow">
                      <div class="card-body primary-bg">
                          <div class="rotate">
                              <i class="fas fa-list fa-4x"></i>
                          </div>
                          <h6 class="text-uppercase">Validasi Tiket</h6>
                          <h1 class=""></h1>
                      </div>
                  </div>
                </a>
              </div>
          <div class="col-xl-2 col-sm-6 py-2">
              <a href="{{ route('account.wisata.user-wisatakuliner') }}">
              <div class="card dashboard-card text-white  h-100 shadow">
                  <div class="card-body bg-success">
                      <div class="rotate">
                          <i class="fas fa-download fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Kuliner</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
              </a>
          </div>
          <div class="col-xl-2 col-sm-6 py-2">
            <a href="{{ route('account.wisata.user-wisataakomodasi') }}">
            <div class="card dashboard-card text-white  h-100 shadow">
                <div class="card-body bg-info">
                    <div class="rotate">
                        <i class="fas fa-hotel fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Akomodasi</h6>
                    <h1 class=""></h1>
                </div>
            </div>
            </a>
        </div>
          <div class="col-xl-2 col-sm-6 py-2">
              <a href="{{ route('account.wisata.guide.index') }}">
                <div class="card dashboard-card text-white h-100 shadow">
                    <div class="card-body bg-danger">
                        <div class="rotate">
                            <i class="fas fa-th fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Paket Wisata</h6>
                        <h1 class=""></h1>
                    </div>
                </div>
              </a>
          </div>
          <div class="col-xl-2 col-sm-6 py-2">
            <a href="{{ route('account.wisata.even.index') }}">
              <div class="card dashboard-card text-white h-100 shadow">
                  <div class="card-body bg-warning">
                      <div class="rotate">
                          <i class="fas fa-file fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Event</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
            </a>
        </div>
        <div class="col-xl-2 col-sm-6 py-2">
            <a href="{{ route('account.wisata.banerpromo.index') }}">
              <div class="card dashboard-card text-white h-100 shadow">
                  <div class="card-body bg-info">
                      <div class="rotate">
                          <i class="fas fa-file fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Baner Promo</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
            </a>
        </div>
      </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                                    <thead>
                                        <tr>
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
                                    </thead>
                                    <tbody>
                                        @foreach ($wisatawan as $key => $data)
                                            <tr data-entry-id="{{ $data->id }}">
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $data->name ?? '' }}
                                                </td>
                                                <td>
                                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $data->phone) }}"><span class="badge badge-success">{{$data->phone}}</span></a>
                                                </td>
							                    <td>
                                                    <span class="badge badge-primary"><a href="mailto:{{ $data->email }}">{{ $data->email }}</a></span>
                                                </td>
                                              

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
    </div>
    @push('scripts')
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
@endpush

@endsection
