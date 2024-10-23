@extends('layouts.author.account')
@section('content')
<div class="account-layout  border">
    <div class="row mb-3">
        <div class="col-xl-4 col-sm-6 py-2">
            <div class="card dashboard-card text-white h-100 shadow">
                <div class="card-body bg-warning">
                    <div class="rotate">
                        <i class="fas fa-file fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Postingan</h6>
                    <h1 class=""></h1>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 py-2">
            <a href="{{ route('account.wisata.user-wisata') }}">
            <div class="card dashboard-card text-white  h-100 shadow">
                <div class="card-body bg-info">
                    <div class="rotate">
                        <i class="fas fa-th fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Profile Wisata</h6>
                    <h1 class=""></h1>
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-4 col-sm-6 py-2">
            <a href="">
              <div class="card dashboard-card text-white h-100 shadow">
                  <div class="card-body bg-danger">
                      <div class="rotate">
                          <i class="fas fa-envelope fa-4x"></i>
                      </div>
                      <h6 class="text-uppercase">Total Pesanan</h6>
                      <h1 class=""></h1>
                  </div>
              </div>
            </a>
        </div>
    </div>
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{route('account.wisata.guide.create')}}">
                    {{ trans('Tambah PaketWisata') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-guide">
                        <thead>
                            <tr>
                                <th>
                                   No
                                </th>
                               
                                <th>
                                    Nama Paket Wisata
                                </th>
                                <th>
                                    Kegiatan
                                </th>
                                
                                <th>
                                    Harga Paket
                                </th>
                                <th>
                                    Tiket termasuk
                                </th>
                                <th>
                                   Tiket Tidak termasuk
                                </th>
                               
                                <th>
                                    Photo
                                </th>
                                <th>
                                    Destinasi
                                 </th>
                               
                                <th>
                                    CP
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Melihat
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guide as $key => $guide)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                                    
                                    <td>
                                        {{ $guide->namapaketwisata ?? '' }}
                                    </td>
                                   
                                    <td>
                                        {!! $guide->kegiatan !!}
                                    </td>
                                   
                                    <td>
                                        @foreach($guide->htpaketwisata as $key => $htpaketwisata)
                                       <span class="badge badge-info ">  {{ $htpaketwisata->jenis }}  Rp. {{ number_format($htpaketwisata->harga, 0, ".", ".") }},-,</span>
                                    @endforeach
                                    </td>
                                   
                                    <td>
                                        {!! $guide->htm !!}
                                    </td>
                                    <td>
                                        {!! $guide->nohtm !!}
                                    </td>
                                    <td>
                                        @foreach($guide->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    <td>
                                        {!! $guide->destinasiwisata !!}
                                    </td>
                                    
                                  
                                    <td>
                                        <span class="badge badge-success">{{$guide->telpon }}</span> 
                                    </td>
                                    <td>
                                        @if($guide->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{ $guide->views }}
                                    </td>
                                
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('account.wisata.guide.show', $hash->encodeHex($guide->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('account.wisata.guide.edit', $hash->encodeHex($guide->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('account.wisata.guide.destroyguide', $hash->encodeHex($guide->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('account.wisata.guide.massDestroyGuide') }}",
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
  $('.datatable-guide:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
    @endpush


    @endsection
