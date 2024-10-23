@extends('layouts.author.account')
@section('content')
<div class="container">
<div class="card">
    <div class="card-header">
      <h3>Check In</h3>
    </div>

    <div class="card-body">
        <div class="row col-lg-12">
           
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <form action="/wisata/cekreserv" method="get">
          <div class="mb-3">
            <label for="kodeboking" class="form-label">Untuk cek Reservasi Akomodasi, silahkan masukan Kodebooking</label>
            <input type="text" name="kodeboking" class="form-control" id="kodeboking" required>
          </div>
          <button type="submit" class="btn btn-primary">Cek Reservasi Akomodasi</button>
        </form>
    </div>
      
  </div>
  <div class="card-header">
      
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-wisata">
                        <thead>
                            <tr>
                               
                                <th>
                                    No
                                </th>
                               
                                <th>
                                    Nama Akomodasi
                                </th>
                                <th>
                                    Kode Booking
                                </th>
                                <th>
                                    Wisatawan
                                </th>
                                <th>
                                    Total
                                </th>
                                <th>
                                    Tanggal Kunjungan
                                </th>
                                <th>
                                    Status Pembayaran
                                </th>
                                <th>
                                    Status Pesanan
                                </th>
                                <th>
                                    Metode Pembayaran
                                </th>
                                <th>
                                    Tanggal Buat
                                </th>
                              
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservation as $key => $reserv)
                                <tr data-entry-id="{{ $reserv->id }}" >
                                  
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    
                                    <td>
                                                          {{ $reserv->akomodasi->namaakomodasi ?? '' }}
                                    </td>
                                   
                                    <td>
                                        <a href="{{ route('account.wisata.reservation', $hash->encodeHex($reserv->id)) }}">{{ $reserv->kodeboking ?? '' }}</a>
                                    </td>
                                    
                                   
                                    <td>
                                        {{ $reserv->wisatawan->name ?? '' }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($reserv->totalHarga, 0, ".", ".") }},-
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($reserv->tanggalkunjungan)) }}
                                    </td>
                                    
                                    
                                  
                                    @if ($reserv->payment_status == 00)
                                    <td><span class="badge badge-info ">Menunggu Pembayaran</span></td>
                                @elseif ($reserv->payment_status == 11)
                                    <td><span class="badge badge-success">Sudah di Bayar</span></td>
                                @elseif ($reserv->payment_status == 22)
                                    <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                @elseif ($reserv->payment_status == 33)
                                    <td><span class="badge badge-danger">Batal</span></td>
                                @endif

                                @if ($reserv->statuspemakaian == 00)
                                    <td><span class="badge badge-info ">Belum Terpakai</span></td>
                                @elseif ($reserv->statuspemakaian == 11)
                                    <td><span class="badge badge-success">Sudah Terpakai</span></td>
                                @elseif ($reserv->statuspemakaian == 22)
                                    <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                @endif
                                    <td>
                                        {{$reserv->metodepembayaran }}
                                    </td>
                                    <td>
                                        {{$reserv->created_at }}
                                    </td>
                                   
                                    
                                    

                                </tr>
                                @endforeach

                        </tbody>
                    </table>
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
    url: "",
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