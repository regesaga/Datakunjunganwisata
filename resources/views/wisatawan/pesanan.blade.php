@extends('layouts.author.wisatawan')

@section('content')
    <div class="account-bdy p-3">
        <section class="author-company-info">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Tiket Saya</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class=" table table-bordered table-striped table-hover datatable datatable-wisata">
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>
                                                            No
                                                        </th>
                                                       
                                                        <th>
                                                            Nama Wisata
                                                        </th>
                                                        <th>
                                                            Kode Tiket
                                                        </th>
                                                        
                                                        <th>
                                                            Total Harga
                                                        </th>
                                                        <th>
                                                            Tanggal Kunjungan
                                                        </th>
                                                        <th>
                                                            Metode Pembayaran
                                                        </th>
                                                        <th>
                                                            Status Pembayaran
                                                        </th>
                                                        <th>
                                                            Status Tiket
                                                        </th>
                                                        <th>
                                                            tanggal Buat
                                                        </th>
                                                        <th>
                                                            Cetak
                                                        </th>
                                                        
                                                        
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pesantiket as $key => $pesantiket)
                                                        <tr data-entry-id="{{ $pesantiket->id }}" >
                                                           
                                                            <td>
                                                                {{$loop->iteration}}
                                                            </td>
                                                            
                                                            <td>
                                                              {{ $pesantiket->wisata->namawisata ?? '' }}
                                                               
                                                            </td>
                                                            <td>
                                                            <a href="{{ route('wisatawan.detailpesanan', $hash->encodeHex($pesantiket->id)) }}">
                                                                {{ $pesantiket->kodetiket ?? '' }}</a>
                                                            </td>
                                                            
                                                           
                                                           
                                                            <td>
                                                                Rp. {{ number_format($pesantiket->totalHarga, 0, ".", ".") }},-
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($pesantiket->tanggalkunjungan)) }}</td>
                                                            <td>{{ $pesantiket->metodepembayaran }}</td>
                                                            
                                                            
                                                          
                                                            @if ($pesantiket->payment_status == 00)
                                                                <td><span class="badge badge-info ">Menunggu Pembayaran</span></td>
                                                            @elseif ($pesantiket->payment_status == 11)
                                                                <td><span class="badge badge-success">Sudah di Bayar</span></td>
                                                            @elseif ($pesantiket->payment_status == 22)
                                                                <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                                            @elseif ($pesantiket->payment_status == 33)
                                                                <td><span class="badge badge-danger">Batal</span></td>
                                                            @endif
                                                                                @if ($pesantiket->statuspemakaian == 00)
                                                            <td><span class="badge badge-info ">Belum Terpakai</span></td>
                                                        @elseif ($pesantiket->statuspemakaian == 11)
                                                            <td><span class="badge badge-success">Sudah Terpakai</span></td>
                                                        @elseif ($pesantiket->statuspemakaian == 22)
                                                            <td><span class="badge badge-danger">Batal</span></td>
                                                        @endif
                                                                <td>
                                                                    {{ date('d-m-Y', strtotime($pesantiket->created_at)) }}
                                                                </td>
                                                                                                                  
                                                            
                                                                <td> 
                                                                    <a href="{{ route('website.pesantiket.checkout_finish', ['pesantiket' => $pesantiket->kodetiket]) }}">
                                                                        <span class="badge badge-danger">Cetak</span>
                                                                    </a>
                                                                </td>
                                                        @endforeach
                        
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                </div>
            </div>
        </section>
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
  $('.datatable-wisata:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>

@endpush

@endsection