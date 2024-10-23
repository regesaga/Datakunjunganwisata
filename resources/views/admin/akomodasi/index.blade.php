@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Akomodasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route("admin.akomodasi.create") }}">
                            {{ trans('Tambah Akomodasi') }} 
                        </a>
                    </div>
                
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-akomodasi">
                                <thead>
                                    <tr>
                                        <th>
                                            Pilih
                                        </th>
                                        <th>No</th>
                                        <th>Pemilik</th>
                                        <th>
                                            Nama Akomodasi
                                        </th>
                                        <th>
                                            Kategori Akomodasi
                                        </th>
                                        <th>
                                            Alamat
                                        </th>
                                        <th>
                                            Kecamatan
                                        </th>
                                        
                                        {{-- <th>
                                            Fasilitas
                                        </th> --}}
                                        <th>
                                            Telepon
                                        </th>
                                        <th>
                                            Instagram
                                        </th>
                                        {{-- <th>
                                            Photo
                                        </th> --}}
                                        <th>
                                            Jam Oprasional
                                        </th>
                                        {{-- <th>
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
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($akomodasi as $key => $akomodasi)
                                        <tr data-entry-id="{{ $akomodasi->id }}" >
                                            <td>
                                            
                                            </td>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{ $akomodasi->company->nama }} || {{$akomodasi->company->user->name}} || @foreach ($akomodasi->company->user->roles as $role)
                                                {{ $role->name }}
                                            @endforeach
                                            </td>
                                            
                                            <td>
                                                {{ $akomodasi->namaakomodasi ?? '' }}
                                            </td>
                                            <td>
                                                {{ $akomodasi->getCategoryAkomodasi->category_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $akomodasi->alamat ?? '' }}
                                            </td>
                                            <td>
                                                {{ $akomodasi->kecamatan->Kecamatan ?? '' }}
                                            </td>
                                        
                                            {{-- <td>
                                                @foreach($akomodasi->fasilitas as $key => $fasilitas)
                                            <span class="badge badge-primary">{{ $fasilitas->fasilitas_name }}</span>
                                            @endforeach
                                            </td> --}}
                                            <td>
                                                {{ $akomodasi->telpon ?? '' }}
                                            </td>
                                            <td>
                                                {{ $akomodasi->instagram ?? '' }}
                                            </td>
                                            {{-- <td>
                                                @foreach($akomodasi->photos as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                                </a>
                                            @endforeach
                                            </td> --}}
                                            <td>
                                                {{ $akomodasi->jambuka }} S.d {{ $akomodasi->jamtutup }}
                                            </td>
                                            {{-- <td>
                                                {!! $akomodasi->deskripsi !!}
                                            </td> --}}
                                            <td>
                                                <span class="badge badge-primary">{{$akomodasi->kapasitas }}</span> 
                                            </td>
                                            <td>
                                                @if($akomodasi->active == 1)
                                                <span class="badge badge-success ">Publish</span>
                                            @else
                                            <span class="badge badge-secondary ">Draft</span>
                                            @endif
                                            </td>
                                            <td>
                                                {{ $akomodasi->views ?? '' }}
                                            </td>
                                        
                                            
                                            <td>
                                                <div class="btn-group" aria-label="Basic example">
                                                <a href="akomodasi/{{$akomodasi->id}}/rekomendasiakomodasi" class="btn btn-warning btn-sm mr-1"><i class="{{$akomodasi->rekomendasiakomodasi ? 'fas fa-star' : 'far fa-star'}}"></i> Rekomendasi</a>
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.akomodasi.show', $hash->encodeHex($akomodasi->id)) }}">
                                                        Detail
                                                    </a>

                                                    <a class="btn btn-xs btn-info" href="{{ route('admin.akomodasi.edit', $hash->encodeHex($akomodasi->id)) }}">
                                                        Edit  
                                                    </a>

                                                    <form action="{{ route('admin.akomodasi.destroy', $hash->encodeHex($akomodasi->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('admin.akomodasi.massDestroy') }}",
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
  $('.datatable-akomodasi:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
