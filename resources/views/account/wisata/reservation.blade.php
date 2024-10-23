@extends('layouts.author.account')
@section('content')
        <div class="card">
           
          
           

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-info" href="{{ route("account.wisata.reserv") }}">
                        {{ trans('Back') }} 
                    </a>
                </div>
        
                <div class="card-body">
                    @if($reservation->isNotEmpty())
                        <table class="table table-bordered table-striped table-hover datatable datatable-wisata">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation as $detail)
                                    <tr>
                                        <td>{{ $detail->nama }}</td>
                                        <td>Rp. {{ number_format($detail->harga, 0, ".", ".") }},-</td>
                                        <td>{{ $detail->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Data detail pesan tidak ditemukan.</p>
                    @endif
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
        url: "{{ route('account.wisata.kulinerproduk.massDestroy') }}",
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