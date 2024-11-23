@extends('layouts.author.account')
@section('content')
<div class="account-layout  border">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-outline-success btn-sm" href="{{ route("account.kuliner.kulinerproduk.create") }}">
                    {{ trans('Tambah Produk') }} 
                </a>
            </div>
            <div class="row mb-3">
                <div class="col-xl-4 col-sm-6 py-2">
                    <a href="{{ route('account.kuliner.pesankuliner') }}">
                      <div class="card dashboard-card text-white h-100 shadow">
                          <div class="card-body bg-primary">
                              <div class="rotate">
                                  <i class="fas fa-box fa-4x"></i>
                              </div>
                              <h6 class="text-uppercase">Pesanan</h6>
                              <h1 class=""></h1>
                          </div>
                      </div>
                    </a>
                </div>
                <div class="col-xl-4 col-sm-6 py-2">
                    <a href="{{ route('account.kuliner.even.index') }}">
                      <div class="card dashboard-card text-white h-100 shadow">
                          <div class="card-body bg-warning">
                              <div class="rotate">
                                  <i class="fas fa-file fa-4x"></i>
                              </div>
                              <h6 class="text-uppercase">Even</h6>
                              <h1 class=""></h1>
                          </div>
                      </div>
                    </a>
                </div>
    
              
              
              <div class="col-xl-4 col-sm-6 py-2">
                  <a href="{{ route('account.kuliner.banerpromo.index') }}">
                    <div class="card dashboard-card text-white h-100 shadow">
                        <div class="card-body bg-danger">
                            <div class="rotate">
                                <i class="fas fa-image fa-4x"></i>
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
                    <table class=" table table-bordered table-striped table-hover datatable datatable-kulinerproduk">
                        <thead>
                            <tr>
                                <th>No</th>
                               
                                <th>
                                    Nama Kuliner
                                </th>
                                <th>
                                    Nama Produk
                                </th>
                                
                                <th>
                                    Deskripsi
                                </th>
                                <th>
                                    Harga
                                </th>
                              
                                
                                <th>
                                    Status 
                                </th>
                                <th>
                                    Melihat 
                                </th>
                                
                                <th>
                                    Photo
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kulinerproduks as $key => $kulinerproduk)
                                <tr data-entry-id="{{ $kulinerproduk->id }}" >
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $kulinerproduk->kuliner->namakuliner ?? '' }}
                                    </td>
                                    <td>
                                        {{ $kulinerproduk->nama  }}
                                    </td>
                                   
                                    <td>
                                        {!! $kulinerproduk->deskripsi !!}
                                    </td>
                                    <td>
                                        <span class="badge badge-info ">  Rp. {{ number_format($kulinerproduk->harga, 0, ".", ".") }},-</span>
                                    </td>
                                   
                                    
                                    <td>
                                        @if($kulinerproduk->active == 1)
                                        <span class="badge badge-success ">Sedia</span>
                                    @else
                                    <span class="badge badge-secondary ">Tidak Sedia</span>
                                    @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info "> {{ $kulinerproduk->views }}</span>
                                    </td>
                                   
                                    <td>
                                        @foreach($kulinerproduk->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('account.kuliner.kulinerproduk.show', $hash->encodeHex($kulinerproduk->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('account.kuliner.kulinerproduk.edit', $hash->encodeHex($kulinerproduk->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('account.kuliner.kulinerproduk.destroy', $hash->encodeHex($kulinerproduk->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('Hapus') }}">
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
    url: "{{ route('account.kuliner.kulinerproduk.massDestroy') }}",
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
  $('.datatable-kulinerproduk:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>

@endpush

@endsection