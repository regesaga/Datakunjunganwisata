@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Kuliner</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-lg-12">
        <div class="card" >
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("admin.kuliner.create") }}">
                    {{ trans('Tambah Kuliner') }} 
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-kuliner">
                        <thead>
                            <tr>
                                <th>
                                    Pilih
                                </th>
                                <th>No</th>
                                <th>Pemilik</th>
                                <th>
                                    Nama Kuliner
                                </th>
                                <th>
                                    Kategori
                                </th>
                                <th>
                                    Alamat
                                </th>
                                <th>
                                    Kecamatan
                                </th>
                                <th>
                                    Telepon
                                </th>
                                <th>
                                    Instagram
                                </th>
                                {{-- <th>
                                    Photo
                                </th>
                                <th>
                                    Deskripsi
                                </th> --}}
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
                                    Jam Oprasional
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kuliners as $key => $kuliner)
                                <tr data-entry-id="{{ $kuliner->id }}" >
                                    <td>
                                    
                                    </td>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        {{ $kuliner->company->nama }} || {{$kuliner->company->user->name}} || @foreach ($kuliner->company->user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                        {{ $kuliner->namakuliner ?? '' }}
                                    </td>
                                    <td>
                                        {{ $kuliner->getCategory->category_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $kuliner->alamat ?? '' }}
                                    </td>
                                    <td>
                                        {{ $kuliner->kecamatan->Kecamatan ?? '' }} 
                                    </td>
                                    <td>
                                        {{ $kuliner->telpon ?? '' }}
                                    </td>
                                    <td>
                                        {{ $kuliner->instagram ?? '' }}
                                    </td>
                                    {{-- <td>
                                        @foreach($kuliner->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                        {!! $kuliner->deskripsi !!}
                                    </td> --}}
                                    <td>
                                        <span class="badge badge-primary">{{$kuliner->kapasitas }}</span>
                                    </td>
                                    <td>
                                        @if($kuliner->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{ $kuliner->views ?? '' }}
                                    </td>
                                    <td>
                                        {{ $kuliner->jambuka ?? '' }} -  {{ $kuliner->jamtutup ?? '' }}
                                    </td>
                                
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                        <a href="kuliner/{{$kuliner->id}}/rekomendasikuliner" class="btn btn-warning btn-sm mr-1"><i class="{{$kuliner->rekomendasikuliner ? 'fas fa-star' : 'far fa-star'}}"></i> Rekomendasi</a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.kuliner.show', $hash->encodeHex($kuliner->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.kuliner.edit', $hash->encodeHex($kuliner->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('admin.kuliner.destroy', $hash->encodeHex($kuliner->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
