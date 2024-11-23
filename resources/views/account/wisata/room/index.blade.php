@extends('layouts.author.account')
@section('content')
<div class="col-lg-12" style="padding-right: 35px;">
        <div class="card" style="margin-right: 100px;">
            <div class="card-header">
                <a class="btn btn-outline-success btn-sm" href="{{ route("account.wisata.room.create") }}">
                    {{ trans('Tambah Room') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-room">
                        <thead>
                            <tr>
                               
                                <th>No</th>
                                <th>
                                    Nama Kamar
                                </th>
                                <th>
                                    Tipe Kamar
                                </th>
                                <th>
                                    Deskripsi
                                </th>
                                <th>
                                    Harga
                                </th>
                                <th>
                                    Kapasitas
                                </th>
                                <th>
                                    Status 
                                </th>
                                <th>
                                    Melihat 
                                </th>
                                <th>
                                    Fasilitas
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
                            @foreach($rooms as $key => $room)
                                <tr data-entry-id="{{ $room->id }}" >
                                    
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $room->nama ?? '' }}
                                    </td>
                                    <td>
                                        {{ $room->getCategory->category_name ?? '' }}
                                    </td>
                                    <td>
                                        {!! $room->deskripsi !!}
                                    </td>
                                    <td>
                                        <span class="badge badge-info "> Rp. {{ number_format($room->harga, 0, ".", ".") }},-</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{$room->kapasitas }} Orang</span> 
                                    </td>
                                    <td>
                                        @if($room->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{ $room->views}}
                                    </td>
                                    <td>
                                        @foreach($room->fasilitas as $key => $fasilitas)
                                       <span class="badge badge-primary">{{ $fasilitas->fasilitas_name }}</span>
                                    @endforeach
                                    </td>
                                    <td>
                                        @foreach($room->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('account.wisata.room.show', $hash->encodeHex($room->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('account.wisata.room.edit', $hash->encodeHex($room->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('account.wisata.room.destroy', $hash->encodeHex($room->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('account.wisata.room.massDestroy') }}",
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
  $('.datatable-room:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>

@endpush

@endsection