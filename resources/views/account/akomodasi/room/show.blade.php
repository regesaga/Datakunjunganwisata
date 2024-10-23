@extends('layouts.author.account')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Detail Kamar  
            </div>
           

            <div class="card-body">
                <div class="form-group">
                    
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-ShowWisata">
                        <tbody>
                            <tr>
                                <th>
                                    Nama Akomodasi
                                </th>
                                <td>
                                    {{ $room->akomodasi->namaakomodasi }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Nama Kamar
                                </th>
                                <td>
                                    {{ $room->nama }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tipe Kamar
                                </th>
                                <td>
                                    {{ $room->getCategory->category_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Deskripsi
                                </th>
                                <td>
                                    {!! $room->deskripsi !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    @if($room->active == 1)
                                    <span class="badge badge-success ">Publish</span>
                                @else
                                <span class="badge badge-secondary ">Draft</span>
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Harga
                                </th>
                                <td>
                                    <span class="badge badge-info ">  Rp. {{ number_format($room->harga, 0, ".", ".") }},-</span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Photo
                                </th>
                                <td>
                                    @foreach($room->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Fasilitas
                                </th>
                                <td>
                                    @foreach($room->fasilitas as $key => $fasilitas)
                                    <span class="badge badge-primary">{{ $fasilitas->fasilitas_name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Kapasitas
                                </th>
                                <td>
                                    <span class="badge badge-primary">{{$room->kapasitas }} Orang</span> 
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="ri-eye-fill"></i>Melihat
                                </th>
                                <td>
                                    {{ $room->views }}
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('account.akomodasi.room.index') }}">
                            Kembali
                        </a>
                        <a class="btn btn-outline-primary" href="{{ route('account.akomodasi.room.edit', $hash->encodeHex($room->id)) }}">
                            Edit  
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function() {
let copyButtonTrans = '{{ trans('copy') }}'
let csvButtonTrans = '{{ trans('Simpan csv') }}'
let excelButtonTrans = '{{ trans('Simpan excel') }}'
let pdfButtonTrans = '{{ trans('Simpan pdf') }}'
let printButtonTrans = '{{ trans('Simpan print') }}'
let colvisButtonTrans = '{{ trans('Baris Tabel') }}'

let languages = {
'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json'
};

$.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
$.extend(true, $.fn.dataTable.defaults, {
language: {
  url: languages['{{ app()->getLocale() }}']
},
columnDefs: [{
    orderable: false,
    className: 'select-checkbox',
    targets: 0
}, {
    orderable: false,
    searchable: false,
    targets: -1
}],
select: {
  style:    'multi+shift',
  selector: 'td:first-child'
},
order: [],
scrollX: true,
pageLength: 100,
dom: 'lBfrtip<"actions">',
buttons: [
  {
    extend: 'copy',
    className: 'btn-default',
    text: copyButtonTrans,
    exportOptions: {
      columns: ':visible'
    }
  },
  {
    extend: 'csv',
    className: 'btn-default',
    text: csvButtonTrans,
    exportOptions: {
      columns: ':visible'
    }
  },
  {
    extend: 'excel',
    className: 'btn-default',
    text: excelButtonTrans,
    exportOptions: {
      columns: ':visible'
    }
  },
  {
    extend: 'pdf',
    className: 'btn-default',
    text: pdfButtonTrans,
    exportOptions: {
      columns: ':visible'
    }
  },
  {
    extend: 'print',
    className: 'btn-default',
    text: printButtonTrans,
    exportOptions: {
      columns: ':visible'
    }
  },
  {
    extend: 'colvis',
    className: 'btn-default',
    text: colvisButtonTrans,
    exportOptions: {
      columns: ':visible'
    }
  }
]
});

$.fn.dataTable.ext.classes.sPageButton = '';
});

</script>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('account.akomodasi.room.massDestroy') }}",
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
  $('.datatable-ShowWisata:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
@endpush
@endsection



