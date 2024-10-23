@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Wisata</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route("admin.wisata.create") }}">
                    {{ trans('Tambah Wisata') }} 
                </a>
            </div>
          
           

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-wisata">
                        <thead>
                            <tr>
                                <th>
                                    Pilih
                                </th>
                                <th>
                                    No
                                </th>
                                <th>
                                    Pemilik
                                </th>
                               
                                <th>
                                    Nama Wisata
                                </th>
                                <th>
                                    Kategori Wisata
                                </th>
                                <th>
                                    Alamat
                                </th>
                                <th>
                                    Kecamatan
                                </th>
                                <th>
                                    Harga Tiket
                                </th>
                                <th>
                                    Fasilitas
                                </th>
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
                                    Melihat
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wisatas as $key => $wisata)
                                <tr data-entry-id="{{ $wisata->id }}" >
                                    <td>
                                    
                                    </td>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        {{ $wisata->company->nama }} || {{$wisata->company->user->name}} || @foreach ($wisata->company->user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                        {{ $wisata->namawisata ?? '' }}
                                    </td>
                                    <td>
                                        {{ $wisata->getCategory->category_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $wisata->alamat ?? '' }}
                                    </td>
                                    <td>
                                        {{ $wisata->kecamatan->Kecamatan ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($wisata->hargatiket as $key => $hargatiket)
                                       <span class="badge badge-info ">  {{ $hargatiket->kategori }} Rp.{{ $hargatiket->harga }},</span>
                                    @endforeach
                                    </td>
                                    <td>
                                        @foreach($wisata->fasilitas as $key => $fasilitas)
                                       <span class="badge badge-primary">{{ $fasilitas->fasilitas_name }}</span>
                                    @endforeach
                                    </td>
                                    <td>
                                        {{ $wisata->telpon ?? '' }}
                                    </td>
                                    <td>
                                        {{ $wisata->instagram ?? '' }}
                                    </td>
                                    {{-- <td>
                                        @foreach($wisata->photos as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                    </td> --}}
                                    <td>
                                        {{ $wisata->jambuka }} S.d {{ $wisata->jamtutup }}
                                    </td>
                                    {{-- <td>
                                        {!! $wisata->deskripsi !!}
                                    </td> --}}
                                    <td>
                                        <span class="badge badge-light">{{$wisata->kapasitas }}</span> 
                                    </td>
                                    <td>
                                        <span class="badge badge-light">{{$wisata->views }}</span> 
                                    </td>
                                    <td>
                                        @if($wisata->active == 1)
                                        <span class="badge badge-success ">Publish</span>
                                    @else
                                    <span class="badge badge-secondary ">Draft</span>
                                    @endif
                                    </td>
                                
                                    
                                    <td>
                                        <div class="btn-group" aria-label="Basic example">
                                        <a href="wisata/{{$wisata->id}}/rekomendasiwisata" class="btn btn-warning btn-sm mr-1"><i class="{{$wisata->rekomendasiwisata ? 'fas fa-star' : 'far fa-star'}}"></i> Rekomendasi</a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.wisata.show', $hash->encodeHex($wisata->id)) }}">
                                                Detail
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.wisata.edit', $hash->encodeHex($wisata->id)) }}">
                                                Edit  
                                            </a>

                                            <form action="{{ route('admin.wisata.destroy', $hash->encodeHex($wisata->id)) }}" method="POST" onsubmit="return confirm('{{ trans('anda yakin akan menghapus?') }}');" >
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
    url: "{{ route('admin.wisata.massDestroy') }}",
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
