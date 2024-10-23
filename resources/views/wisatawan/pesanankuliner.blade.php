@extends('layouts.author.wisatawan')

@section('content')
    <div class="account-bdy p-3">
        <section class="author-company-info">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Pesanan Saya</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class=" table table-bordered table-striped table-hover datatable datatable-kuliner">
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>
                                                            No
                                                        </th>
                                                       
                                                        <th>
                                                            Nama Kuliner
                                                        </th>
                                                        <th>
                                                            Kode Pesanan
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
                                                            Status Pesanan
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
                                                    @foreach($pesankuliner as $key => $pesankuliner)
                                                        <tr data-entry-id="{{ $pesankuliner->id }}" >
                                                           
                                                            <td>
                                                                {{$loop->iteration}}
                                                            </td>
                                                            
                                                            <td>
                                                              {{ $pesankuliner->kuliner->namakuliner ?? '' }}
                                                               
                                                            </td>
                                                            <td>
                                                            <a href="{{ route('wisatawan.detailpesanan', $hash->encodeHex($pesankuliner->id)) }}">
                                                                {{ $pesankuliner->kodepesanan ?? '' }}</a>
                                                            </td>
                                                            
                                                           
                                                           
                                                            <td>
                                                                Rp. {{ number_format($pesankuliner->totalHarga, 0, ".", ".") }},-
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($pesankuliner->tanggalkunjungan)) }}</td>
                                                            <td>{{ $pesankuliner->metodepembayaran }}</td>
                                                            
                                                            
                                                          
                                                            @if ($pesankuliner->payment_status == 00)
                                                                <td><span class="badge badge-info ">Menunggu Pembayaran</span></td>
                                                            @elseif ($pesankuliner->payment_status == 11)
                                                                <td><span class="badge badge-success">Sudah di Bayar</span></td>
                                                            @elseif ($pesankuliner->payment_status == 22)
                                                                <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                                            @elseif ($pesankuliner->payment_status == 33)
                                                                <td><span class="badge badge-danger">Batal</span></td>
                                                            @endif
                                                                                @if ($pesankuliner->statuspemakaian == 00)
                                                            <td><span class="badge badge-info ">Belum Terpakai</span></td>
                                                        @elseif ($pesankuliner->statuspemakaian == 11)
                                                            <td><span class="badge badge-success">Sudah Terpakai</span></td>
                                                        @elseif ($pesankuliner->statuspemakaian == 22)
                                                            <td><span class="badge badge-danger">Batal</span></td>
                                                        @endif
                                                                <td>
                                                                    {{ date('d-m-Y', strtotime($pesankuliner->created_at)) }}
                                                                </td>
                                                                                                                  
                                                            
                                                                <td> 
                                                                    <a href="{{ route('website.pesankuliner.checkout_finish', ['pesankuliner' => $pesankuliner->kodepesanan]) }}">
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
  $('.datatable-kuliner:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>

@endpush

@endsection