@extends('layouts.author.account')
@section('content')
<div class="account-layout  border">
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
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("account.wisata.even.create") }}">
                    {{ trans('Tambah Event') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-even">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                               
                                <th>
                                    Nama Event
                                </th>
                                <th>
                                    Deskripsi
                                </th>
                                <th>
                                    lokasi
                                </th>  
                                <th>
                                    waktu mulai
                                </th>
                                <th>
                                    waktu selesai
                                </th>
                                 
                                <th>
                                    Photo
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($even as $key => $even)
                                <tr data-entry-id="{{ $even->id }}" >
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    
                                    <td>
                                        {{ $even->title ?? '' }}
                                    </td>
                                    <td>
                                        {!! $even->deskripsi !!}
                                    </td>
                                    <td>
                                        {{ $even->lokasi ?? '' }}
                                    </td>
                                    <td>
                                        {{ $even->jammulai ?? '' }}
                                    </td>
                                    <td>
                                        {{ $even->jamselesai ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($even->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    
                                
                                    <td>
                                        @if($even->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('account.wisata.even.show', $hash->encodeHex($even->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('account.wisata.even.edit', $hash->encodeHex($even->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('account.wisata.even.destroy', $hash->encodeHex($even->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('account.wisata.even.massDestroy')}}",
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
  $('.datatable-even:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function () {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                


            })
        });
</script>

@endpush


@endsection