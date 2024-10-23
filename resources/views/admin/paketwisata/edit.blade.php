@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Guide</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Edit Obyek Wisata
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("admin.paketwisata.update", $hash->encodeHex($paketwisata->id)) }}"   enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    
                                
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            Nama Paket Wisata 
                            <div >
                                <input class="form-control" type="text" name="namapaketwisata" id="namapaketwisata" value="{{ $paketwisata->namapaketwisata }}" required>
                            </div>
                        </div>
                        

                        <div class="col-lg-3 col-md-3">
                            Input sebagai:
                            <div>
                              <select class="form-control" name="company_id" required>
                                <option value="{{ $paketwisata->company_id }}" selected>{{ $paketwisata->company->nama }}</option>
                                @foreach ($company as $companyItem)
                                @if ($companyItem->user && $companyItem->user->roles)
                                  @foreach ($companyItem->user->roles as $role)
                                    @if ($role->name === 'guide')
                                      <option value="{{ $companyItem->id }}">{{ $companyItem->nama }}|{{$companyItem->user->email}}</option>
                                    @endif
                                  @endforeach
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        
                    </div>
                    <br>
                    <div class="row">
                        
                        <div class="col-lg-6 col-md-6">
                            Kegiatan
                            <div >
                                <textarea class="form-control" name="kegiatan" id="deskripsi" required>{{ $paketwisata->kegiatan }}</textarea>
                            </div>
                        </div>
                                                                
                        <div class="col-lg-6 col-md-6">
                            Photo Paket Wisata
                            <div>
                                <div class="needsclick dropzone" {{ $errors->has('photos') ? 'is-invalid' : '' }} id="photos-dropzone">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            Harga termasuk 
                            <div >
                                <textarea class="form-control" name="htm" id="deskripsi1" required>{{ $paketwisata->htm }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            Harga Tidak termasuk
                            <div >
                                <textarea class="form-control" name="nohtm" id="deskripsi2" required>{{ $paketwisata->nohtm }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            Destinasi Wisata
                            <div >
                                <textarea class="form-control" name="destinasiwisata" id="deskripsi3" required>{{ $paketwisata->destinasiwisata }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            Contact Person
                            <div >
                                <textarea class="form-control" name="telpon" id="telpon" required>{{ $paketwisata->telpon }}</textarea>
                            </div>
                        </div>
                                
                                     
                        <div class="col-lg-1 col-md-1">
                            Status   
                            <select name="active" class="form-control" required>
                                <option value="1" {{ $paketwisata->active == '1' ? 'selected':'' }}>Publish</option>
                                <option value="0" {{ $paketwisata->active == '0' ? 'selected':'' }}>Draft</option>
                            </select>
                            
                            @if($errors->has('active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('active') }}
                                </div>
                            @endif
                        </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-8">
                                                <a href="#" class="addtiket btn btn-primary" style="right;">Tambah Harga Tiket</a>
                                            </div>
                                        </div>
                                        @foreach ($paketwisata->htpaketwisata as $htpaketwisata)
                                        <label class="font-weight-bold">Jenis {{ $loop->iteration }}</label>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2">
                                                <label class="required" for="jenis">Jenis</label>
                                                <input type="text" class="form-control" name="jenis[]" value="{{ $htpaketwisata->jenis }}" required>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <label class="required" for="harga">Harga</label>
                                                <input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required name="harga[]" value="{{ $htpaketwisata->harga }}"required>
                                            </div>
                                            <div class="col-lg-2 col-md-2"><label class="col-sm-2 col-form-label"></label><div class="col-sm-8"> <a href="#" class="remove btn btn-danger" style="float: right;">Hapus</a></div></div></div><div>
                                        </div>
                                     @endforeach

                                        <div class="tiket"></div>
                                        <br>
                            
                    <div class="card-footer">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">
                            {{ trans('Simpan') }}
                        </button>
                    </div>
                </form>
    
                                 
                                 
                   
            </div>
        </div>
    </div>
        </div>
    </div>
</main>
<script>
   var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('admin.paketwisata.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
      uploadedPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotosMap[file.name]
      }
      $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($paketwisata) && $paketwisata->photos)
      var files =
        {!! json_encode($paketwisata->photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>

<script type="text/javascript">
    $(document).on('click', '.addtiket', function() {
      addtiket();
    });
  
    function addtiket() {
      var tiket =
        '<div><div class="row"><div class="col-lg-2 col-md-2"><label class="required" for="jenis">Jenis</label><input type="text" class="form-control" name="jenis[]"  value="{{ old('jenis') }}" required></div><div class="col-lg-2 col-md-2"><label class="required" for="harga" value="{{ old('harga') }}">Harga</label><input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required class="form-control" name="harga[]" required></div><div class="col-lg-2 col-md-2"><label class="col-sm-2 col-form-label"></label><div class="col-sm-8"> <a href="#" class="remove btn btn-danger" style="float: right;">Hapus</a></div></div></div><div>';
      $('.tiket').append(tiket);
    }
  
    $(document).on('click', '.remove', function() {
      $(this).parent().parent().parent().remove();
    });
  </script>
  
  <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
  <script>
      CKEDITOR.replace('deskripsi');
      CKEDITOR.replace('deskripsi1');
      CKEDITOR.replace('deskripsi2');
      CKEDITOR.replace('deskripsi3');
  </script>

