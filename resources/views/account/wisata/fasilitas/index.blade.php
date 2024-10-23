@extends('layouts.author.account')
@section('content')

<div class="col-lg-12">
    <div class="row mb-3">
        <div class="col-xl-3 col-sm-6 py-2">
            <a href="{{ route('account.wisata.user-wisata') }}">
              <div class="card dashboard-card text-white h-100 shadow">
                  <div class="card-body primary-bg">
                      <div class="rotate">
                          <i class="fas fa-list fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Profile Wisata</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
            </a>
          </div>
      <div class="col-xl-3 col-sm-6 py-2">
          <a href="{{ route('account.wisata.user-wisatakuliner') }}">
          <div class="card dashboard-card text-white  h-100 shadow">
              <div class="card-body bg-success">
                  <div class="rotate">
                      <i class="fas fa-download fa-4x"></i>
                  </div>
                  <h6 class="text-uppercase">Profile Kuliner</h6>
                  <h1 class=""></h1>
              </div>
          </div>
          </a>
      </div>
      <div class="col-xl-3 col-sm-6 py-2">
        <a href="{{ route('account.wisata.user-wisataakomodasi') }}">
        <div class="card dashboard-card text-white  h-100 shadow">
            <div class="card-body bg-info">
                <div class="rotate">
                    <i class="fas fa-hotel fa-4x"></i>
                </div>
                <h6 class="text-uppercase">Profile Akomodasi</h6>
                <h1 class=""></h1>
            </div>
        </div>
        </a>
    </div>
      <div class="col-xl-3 col-sm-6 py-2">
          <a href="">
            <div class="card dashboard-card text-white h-100 shadow">
                <div class="card-body bg-warning">
                    <div class="rotate">
                        <i class="fas fa-th fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Paket Wisata</h6>
                    <h1 class=""></h1>
                </div>
            </div>
          </a>
      </div>
  </div>
    <a class="btn btn-success" href="{{ route('account.wisata.fasilitas.create') }}">
        Tambah Fasilitas
    </a>
    <div class="card">
        

        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-fasilitas">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fasilitas as $key => $fasilitasItem)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $fasilitasItem->fasilitas_name }}</td>
                            {{-- <td>
                                <a class="btn btn-xs btn-info"
                                    href="{{ route('account.wisata.fasilitas.edit', $hash->encodeHex($fasilitasItem->id)) }}">
                                    Ubah
                                </a>
                                <form action="{{ route('account.wisata.fasilitas.destroy', $fasilitasItem->id) }}"
                                    method="POST" onsubmit="return confirm('{{ trans('areYouSure') }}');"
                                    style="display: inline-block;">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('Delete') }}">
                                </form>
                            </td> --}}
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
    url: "{{ route('account.wisata.fasilitas.massDestroy') }}",
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
  $('.datatable-fasilitas:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>

@endpush

@endsection
