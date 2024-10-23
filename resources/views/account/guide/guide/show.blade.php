@extends('layouts.author.account')
@section('content')
<div class="account-layout  border">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Detail Paket Wisata   
            </div>
           

            <div class="card-body">
                <div class="form-group">
                    
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-ShowWisata">
                        <tbody>
                            
                            {{-- <iframe width="100%" height="500" src="https://maps.google.com/maps?q=kuningan&output=embed"></iframe>  --}}
                            <tr>
                                <th>
                                    Pemilik
                                </th>
                                <td>
                                    {{ $guide->company->nama }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Nama Paket Wisata
                                </th>
                                <td>
                                    {{ $guide->namapaketwisata }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    @if($guide->active == 1)
                                    <span class="badge badge-success ">Publish</span>
                                @else
                                <span class="badge badge-secondary ">Draft</span>
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Kegiatan
                                </th>
                                <td>
                                    {!! $guide->kegiatan !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Destinasi 
                                </th>
                                <td>
                                    {!! $guide->destinasiwisata !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Harga tiket termasuk 
                                </th>
                                <td>
                                    {!! $guide->htm !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Harga Tiket tidak termasuk
                                </th>
                                <td>
                                    {!! $guide->nohtm !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="ri-eye-fill"></i>Melihat
                                </th>
                                <td>
                                    {{ $guide->views }}
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <th>
                                    Photo
                                </th>
                                <td>
                                    @foreach($guide->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>
                                Harga Paket
                                </th>
                                
                                    <td>@foreach ($htpaketwisata as $ticketCategory)
                                        <span class="badge badge-info ">  {{ $ticketCategory->jenis }} Rp.{{ $ticketCategory->harga }}</span>
                            @endforeach

                                    </td>
                            </tr>
                           
                            <tr>
                                <th>
                                    Contact Person
                                </th>
                                <td>
                                    {{ $guide->telpon }}
                                    
                                </td>
                            </tr>
                            
                           
                           
                        </tbody>
                    </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('account.guide.user-guide') }}">
                            Kembali
                        </a>
                        <a class="btn btn-outline-primary" href="{{ route('account.guide.guide.edit', $hash->encodeHex($guide->id)) }}">
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
@endpush
@endsection
