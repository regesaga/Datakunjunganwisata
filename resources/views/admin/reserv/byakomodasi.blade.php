@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Monitoring Pesanan Kuliner</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
    <div class="col-lg-12">
        <div class="card">
            {{-- <div class="card-header">
                <a class="btn btn-outline-success btn-sm" href="{{ route("admin.kuliner.create") }}">
                    {{ trans('Tambah Wisata') }} 
                </a>
            </div> --}}
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-kuliner">
                        <thead>
                        <tr>
                                <th>
                                    Pilih
                                </th>
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
                                    Total Harga
                                </th>
                                <th>
                                    Status Pembayaran
                                </th>
                                <th>
                                    Status Pesanan
                                </th>
                                <th>
                                    Tanggal Buat
                                </th>
                                <th>
                                    Tanggal Kunjungan
                                </th>
                                <th>
                                    Aksi
                                </th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reserv as $key => $reserv)
                            <tr data-entry-id="{{ $reserv->id }}" >
                                    <td>
                                    
                                    </td>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('admin.reserv.byakomodasi', $hash->encodeHex($reserv->reserv_id)) }}"> {{ $reserv->akomodasi->namaakomodasi ?? '' }}</a>
                                       
                                    </td>
                                   
                                    <td>
                                        {{ $reserv->kodeboking ?? '' }}
                                    </td>
                                    
                                   
                                    <td><a href="{{ route('admin.wisatawans.show', $hash->encodeHex($reserv->wisatawan_id)) }}">
                                        {{ $reserv->wisatawan->name ?? '' }}</a>
                                    </td>
                                    <td>
                                        Rp. {{ number_format($reserv->totalHarga, 0, ".", ".") }},-
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

                                    @if ($reserv->statuspesanan == 00)
                                        <td><span class="badge badge-info ">Belum Terpakai</span></td>
                                    @elseif ($reserv->statuspesanan == 11)
                                        <td><span class="badge badge-success">Sudah Terpakai</span></td>
                                    @elseif ($reserv->statuspesanan == 22)
                                        <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                    @endif
                                    <td>
                                        {{$reserv->created_at }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($reserv->tanggalkunjungan)) }}
                                    </td>
                                   
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.reserv.detail', $hash->encodeHex($reserv->id)) }}">
                                                Detail
                                            </a>

                                            {{-- <a class="btn btn-xs btn-info" href="{{ route('admin.reserv.edit', $hash->encodeHex($reserv->id)) }}">
                                                Edit  
                                            </a> --}}

                                            {{-- <form action="{{ route('admin.reserv.destroy', $hash->encodeHex($reserv->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('Hapus') }}">
                                            </form> --}}
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
        </div>
    </div>
</main>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.kuliner.massDestroy') }}",
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
