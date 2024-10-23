@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Room</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-12">
    <div class="card">
        <div class="card-header">
            Tambah Kamar Akomodasi
        </div>
        <div class="card-body">
            <form action="{{route('admin.room.storeRoom')}}"  method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                        
                        {{-- <iframe width="100%" height="500" src="https://maps.google.com/maps?q=kuningan&output=embed"></iframe>  --}}
                        
                                <div class="row">
                                    
                                    <div class="col-lg-5 col-md-5">
                                        Nama Kamar 
                                        <div >
                                            <input class="form-control" type="text" name="nama" id="nama" value="{{ old('nama', '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        Tipe Kamar 
                                        <div >
                                            
                                            <select class="form-control" name="categoryroom_id" value="{{ old('categoryroom_id') }}" required>
                                                @foreach($categories as $category)
                                              <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
            
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        inpus sebagai
                                        <div >
                                            <select class="form-control" name="akomodasi_id" value="{{ old('akomodasi_id') }}" required>
                                                @foreach($akomodasi as $akomodasi)
                                            <option value="{{$akomodasi->id}}">{{$akomodasi->namaakomodasi}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    
                                    <div class="col-lg-6 col-md-6">
                                        Deskripsi
                                        <div >
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                        </div>
                                    </div>
                                                                            
                                    <div class="col-lg-6 col-md-6">
                                        Photo Kamar
                                        <div>
                                            <div class="needsclick dropzone" {{ $errors->has('photos') ? 'is-invalid' : '' }} id="photos-dropzone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3">
                                        Harga 
                                        <div >
                                            <input class="form-control" name="harga" id="harga" value="{{ old('harga', '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        Kapasitas
                                        <select name="kapasitas" class="form-control">
                                            @for($j=1; $j<=5; $j++)
                                            <option value="{{ $j }}">{{ $j }} Orang</option>
                                            @endfor
                                        </select>
                                    </div>
                                        <div class="col-lg-1 col-md-1">
                                            Status
                                            <select name="active" class="form-control" required>
                                                <option value="1" {{ old('active') == '1' ? 'selected':'' }}>Publish</option>
                                                <option value="0" {{ old('active') == '0' ? 'selected':'' }}>Draft</option>
                                            </select>
                                            <p class="text-danger">{{ $errors->first('active') }}</p>
                                        </div> 
                                </div>
                                <br>
                                
                                <div class="form-group">
                                    <label for="fasilitas">Fasilitas</label>
                                    <div style="padding-bottom: 4px">
                                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">select_all</span>
                                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">deselect_all</span>
                                    </div>
                                    
                                    <select class="form-control select2 {{ $errors->has('fasilitas') ? 'is-invalid' : '' }}" name="fasilitas[]" id="fasilitas" multiple>
                                        @foreach($fasilitas as $id => $fasilitas)
                                            <option value="{{ $id }}" {{ in_array($id, old('fasilitas', [])) ? 'selected' : '' }}>{{ $fasilitas }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <br>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success form-control" value="Submit">

                
                </div>
            </form>

        
        </div>
    </div>
</div>
        </div>
    </div>
</main>
<script>
    function validateForm() {
      var deskripsi = document.getElementById("deskripsi").value;
      if (deskripsi.trim() === "") {
        alert("Deskripsi harus diisi, Jika sudah di isi silahkan Submit lagi");
        return false;
      }
      return true;
    }
  </script>

<script>
   var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('admin.room.storeMedia') }}',
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
@if(isset($room) && $room->photos)
      var files =
        {!! json_encode($room->photos) !!}
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
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('deskripsi');
    </script>

</body>






