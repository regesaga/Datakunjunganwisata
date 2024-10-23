@extends('layouts.author.account')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Edit Obyek Akomodasi
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("account.akomodasi.akomodasi.update",$akomodasi->id) }}"    method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                    @csrf
                    @method('PUT')
                                
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                Nama Akomodasi 
                                                <div >
                                                    <input class="form-control" type="text" name="namaakomodasi" id="namaakomodasi"  value="{{ $akomodasi->namaakomodasi }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                Category
                                                <div>
                                                    <select class="form-control" name="categoryakomodasi_id" required>
                                                        <option value="{{$akomodasi->categoryakomodasi_id}}"  {{ $akomodasi->categoryakomodasi_id != "" ? 'selected' : '' }}>{{$akomodasi->getCategoryAkomodasi->category_name}}</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('categoryakomodasi_id', $akomodasi->categoryakomodasi_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                Kapasitas
                                                <div >
                                                    <input class="form-control" type="text" name="kapasitas" id="kapasitas" value="{{ $akomodasi->kapasitas }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                Deskripsi
                                                <div >
                                                    <textarea class="form-control " name="deskripsi" id="deskripsi">{{ $akomodasi->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                Photo Akomodasi
                                                <div>
                                                    <div class="needsclick dropzone" {{ $errors->has('photos') ? 'is-invalid' : '' }} id="photos-dropzone">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                Instagram 
                                                <div >
                                                    <input class="form-control" name="instagram" id="instagram"  value="{{ $akomodasi->instagram }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                Website 
                                                <div >
                                                    <input class="form-control" name="web" id="web"  value="{{ $akomodasi->web }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                Telphone 
                                                <div >
                                                    <input class="form-control" name="telpon" id="telpon"  value="{{ $akomodasi->telpon }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                Buka 
                                                <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                    <input type="text" class="form-control" name="jambuka" value="{{ $akomodasi->jambuka }}" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                Tutup 
                                                <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                                    <input type="text" class="form-control" name="jamtutup" value="{{ $akomodasi->jamtutup }}" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
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
                                                    <option value="{{ $id }}" {{ (in_array($id, old('fasilitas', [])) || $akomodasi->fasilitas->contains($id)) ? 'selected' : '' }}>{{ $fasilitas }}</option>
                                                @endforeach
                                            </select>
        
        
                                        <div class="mapform" >
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    Alamat 
                                                    <div >
                                                        <input class="form-control" type="text" name="alamat" id="alamat" value="{{ $akomodasi->alamat }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2">
                                                    Kecamatan 
                                                    <div >
                                                        <select class="form-control" name="kecamatan_id" required>
                                                            <option value="{{$akomodasi->kecamatan_id}}"  {{ $akomodasi->kecamatan_id != "" ? 'selected' : '' }}>{{$akomodasi->kecamatan->Kecamatan}}</option>
                                                            @foreach($kecamatan as $kecamatan)
                                                                <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $akomodasi->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                                                    {{ $kecamatan->Kecamatan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2">
                                                    Latitude
                                                    <input type="text" class="form-control" placeholder="latitude" name="latitude" id="lat" value="{{ $akomodasi->latitude }}" required>
                                                </div>
                                                <div class="col-lg-2 col-md-2">
                                                longitude
                                                    <input type="text"  class="form-control" placeholder="longitude" name="longitude" id="lng" value="{{ $akomodasi->longitude }}" required>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div id="map" style="height: 600px; width: 100%; position: relative; overflow: hidden;"  class="my-3"></div>
        
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
    <script>
        let map;
        let cityPoligon;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat:  {{ $akomodasi->latitude }} , lng: {{ $akomodasi->longitude }}  },
            zoom: 8,
            scrollwheel: true,
        });
        map.data.loadGeoJson('/js/Kuninganbatas.geojson');
        const uluru = { lat: {{ $akomodasi->latitude }}  , lng: {{ $akomodasi->longitude }}  };
        let marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable: true
        });
    
            google.maps.event.addListener(marker, 'position_changed', function() {
                let lat = marker.position.lat();
                let lng = marker.position.lng();
                $('#lat').val(lat);
                $('#lng').val(lng);
            });
    
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
            });
        }
    </script>
      <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
      <script>
          CKEDITOR.replace('deskripsi');
      </script>
    {{-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" ></script> --}}
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_UNRESTRICTED') }}&callback=initMap" ></script>
        <script src="/admin/dist/bootstrap-clockpicker.min.js"></script>
        
    <script src="/js/mapInput.js"></script>
    <script type="text/javascript">
        $('.clockpicker').clockpicker();
        </script>
<script>
   var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('account.akomodasi.akomodasi.storeMedia') }}',
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
@if(isset($akomodasi) && $akomodasi->photos)
      var files =
        {!! json_encode($akomodasi->photos) !!}
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
  
  

