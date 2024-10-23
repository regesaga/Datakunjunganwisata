@extends('layouts.author.account')
@section('content')

<div class="col-lg-12">
    <div class="row mb-3">
        <div class="col-xl-4 col-sm-6 py-2">
            <a href="{{ route('account.kuliner.user-kuliner') }}">
              <div class="card dashboard-card text-white h-100 shadow">
                  <div class="card-body primary-bg">
                      <div class="rotate">
                          <i class="fas fa-list fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Profile Kuliner</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
            </a>
          </div>
      <div class="col-xl-4 col-sm-6 py-2">
          <a href="{{ route('account.kuliner.kulinerproduk.index') }}">
          <div class="card dashboard-card text-white  h-100 shadow">
              <div class="card-body bg-success">
                  <div class="rotate">
                      <i class="fas fa-download fa-4x"></i>
                  </div>
                  <h6 class="text-uppercase">Produk Kuliner</h6>
                  <h1 class=""></h1>
              </div>
          </div>
          </a>
      </div>
      <div class="col-xl-4 col-sm-6 py-2">
          <a href="{{ route('account.kuliner.even.index') }}">
            <div class="card dashboard-card text-white h-100 shadow">
                <div class="card-body bg-info">
                    <div class="rotate">
                        <i class="fas fa-th fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Even</h6>
                    <h1 class=""></h1>
                </div>
            </div>
          </a>
      </div>
  </div>
<div class="col-lg-12" >
    <div class="card" >
            <!-- Page Heading -->
            
            <div class="card-body">
                <a class="btn btn-success" href="{{ route("account.kuliner.banerpromo.create") }}">
                    <i class="fas fa-plus"></i>     {{ trans('Tambah Baner') }} 
                </a>
                <table class=" table table-bordered table-striped table-hover datatable datatable-banerpromo">
                                <thead>
                                    <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Sampul</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banerpromo as $banerpromo)
                                        <tr>
                                        <th scope="banerpromo">{{$loop->iteration}}</th>
                                        <td><img src="/upload/banerpromo/{{$banerpromo->sampul}}" alt="" width="80px" height="80px"></td>
                                        <td>{{$banerpromo->judul}}</td>
                                        <td>
                                            @if($banerpromo->active == 1)
                                            <span class="badge badge-success ">Publish</span>
                                        @else
                                        <span class="badge badge-secondary ">Draft</span>
                                        @endif
                                        </td>
                                        <td width="25%">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-success" href="{{ route('account.kuliner.banerpromo.show', $hash->encodeHex($banerpromo->id)) }}"><i class="fas fa-eye"></i>
                                                    Detail</a>
                                                <a class="btn btn-info" href="{{ route('account.kuliner.banerpromo.edit', $hash->encodeHex($banerpromo->id)) }}">
                                                    <i class="fas fa-edit"></i> Edit</a>

                                                <form action="{{ route('account.kuliner.banerpromo.destroy', $hash->encodeHex($banerpromo->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
@push('scripts')
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('account.kuliner.banerpromo.massDestroyBanerpromo') }}",
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
  $('.datatable-banerpromo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>

@endpush
@endsection