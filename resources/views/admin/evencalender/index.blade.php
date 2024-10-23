@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Even Calender</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-lg-12" style="padding-right: 35px;">
        <div class="card" style="margin-right: 100px;">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("admin.evencalender.create") }}">
                    {{ trans('Tambah Event') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-evencalender">
                        <thead>
                            <tr>
                                <th width="10">
                                    Pilih
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
                            @foreach($evencalenders as $key => $evencalender)
                                <tr data-entry-id="{{ $evencalender->id }}" >
                                    <td>
                                    
                                    </td>
                                    
                                    <td>
                                        {{ $evencalender->title ?? '' }}
                                    </td>
                                    <td>
                                        {!! $evencalender->deskripsi !!}
                                    </td>
                                    <td>
                                        {{ $evencalender->lokasi ?? '' }}
                                    </td>
                                    <td>
                                        {{ $evencalender->jammulai ?? '' }}
                                    </td>
                                    <td>
                                        {{ $evencalender->jamselesai ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($evencalender->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    
                                
                                    <td>
                                        @if($evencalender->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.evencalender.show', $hash->encodeHex($evencalender->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.evencalender.edit', $hash->encodeHex($evencalender->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('admin.evencalender.destroy', $hash->encodeHex($evencalender->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    <div class="card" style="margin-right: 100px;">

    <div class="card-body">

        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

        <div id='calendar'></div>
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
    url: "{{ route('admin.evencalender.massDestroy') }}",
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
  $('.datatable-evencalender:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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