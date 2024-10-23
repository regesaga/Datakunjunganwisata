@extends('layouts.author.account')
@section('content')
            <div class="card-header">
                Tambah Kamar
            </div>
                    <form action="{{route('account.akomodasi.room.storeRoom')}}"  method="post" enctype="multipart/form-data" onsubmit="return validateForm()" >
                        @csrf
                                
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Nama Kamar</label>  
                                            <div >
                                                <input class="form-control" type="text" name="nama" id="nama"  value="{{ old('nama', '') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Deskripsi</label>
                                            <div >
                                                <textarea class="form-control " name="deskripsi" id="deskripsi" required>{{ old('deskripsi', '') }}</textarea>
                                            </div>
                                        </div>
                                                                                
                                        <div class="form-group">
                                            <label for="name">Photo Kamar</label>
                                            <div>
                                                <div class="needsclick dropzone" {{ $errors->has('photos') ? 'is-invalid' : '' }} id="photos-dropzone">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Tipe Kamar</label>
                                            <select class="form-control" name="categoryroom_id" value="{{ old('categoryroom_id') }}" required>
                                                @foreach($categories as $category)
                                              <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
                                       </div>
                                       <div class="form-group">
                                            <label for="name">Kapasitas</label>
                                            <select name="kapasitas" class="form-control">
                                                @for($j=1; $j<=5; $j++)
                                                <option value="{{ $j }}">{{ $j }} Orang</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                             <label for="name">Harga</label>
                                            <div >
                                                <input class="form-control" name="harga" id="harga" value="{{ old('harga', '') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                                <label for="name">Status</label>   
                                                <select name="active" class="form-control" required>
                                                    <option value="1" {{ old('active') == '1' ? 'selected':'' }}>Publish</option>
                                                    <option value="0" {{ old('active') == '0' ? 'selected':'' }}>Draft</option>
                                                </select>
                                                <p class="text-danger">{{ $errors->first('active') }}</p>
                                        </div>
                                        
                                       
                                    </div>
                                        
                                </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
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
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">
                                                {{ trans('Simpan') }}
                                            </button>
                                        
                                        </div>
                                    </div>  
                                </div>
                                
                       
                    </form>

                
@push('scripts')
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
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('deskripsi');
    </script>
<script>
   var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('account.akomodasi.room.storeMedia') }}',
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

@endpush
@endsection





