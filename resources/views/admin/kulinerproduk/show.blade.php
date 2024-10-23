@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Produk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Detail Produk Kuliner  
            </div>
           

            <div class="card-body">
                <div class="form-group">
                    
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-ShowWisata">
                        <tbody>
                            <tr>
                                <th>
                                    Nama Kuliner
                                </th>
                                <td>
                                    {{ $kulinerproduk->kuliner->namakuliner }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Produk
                                </th>
                                <td>
                                    {{ $kulinerproduk->nama ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Deskripsi
                                </th>
                                <td>
                                    {!! $kulinerproduk->deskripsi !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    @if($kulinerproduk->active == 1)
                                    <span class="badge badge-success ">Sedia</span>
                                @else
                                <span class="badge badge-secondary ">Tidak Sedia</span>
                                @endif
                                </td>
                            </tr>
                            <tr>
                              <th>
                                <i class="ri-eye-fill"></i>Melihat
                              </th>
                              <td>
                                  {{ $kulinerproduk->views }}
                              </td>
                          </tr>
                            <tr>
                                <th>
                                    Harga
                                </th>
                                <td>
                                    <span class="badge badge-info ">  Rp. {{ number_format($kulinerproduk->harga, 0, ".", ".") }},-</span>
                                </td>
                            </tr>
                          
                            <tr>
                                <th>
                                    Photo
                                </th>
                                <td>
                                    @foreach($kulinerproduk->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.kulinerproduk.index') }}">
                            Kembali
                        </a>
                        <a class="btn btn-outline-primary" href="{{ route('admin.kulinerproduk.edit', $hash->encodeHex($kulinerproduk->id)) }}">
                            Edit  
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
    </div>
</main>
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
@yield('scripts')
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.kulinerproduk.massDestroy') }}",
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