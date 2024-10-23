@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Kuliner</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            Edit Kuliner
            </div>
            <div class="card-body">

                <form method="POST" action="{{ route("admin.kuliner.update", $hash->encodeHex($kuliner->id)) }}"   enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                            
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nama Kuliner</label>
                                        <input class="form-control" type="text" name="namakuliner" id="namakuliner" value="{{ $kuliner->namakuliner }}" required>
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea class="form-control " name="deskripsi" id="deskripsi">{{ $kuliner->deskripsi }}</textarea>
                                        <p class="text-danger">{{ $errors->first('deskripsi') }}</p>
                                    </div>
                                    <div class="form-group">
                                        Photo Kuliner
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
                                        <label for="company_id">Input Sebagai</label>
                                        <select class="form-control" name="company_id" required>
                                            <option value="{{ $kuliner->company_id }}" selected>{{ $kuliner->company->nama }}</option>
                                            @foreach ($company as $companyItem)
                                                @if ($companyItem->user && $companyItem->user->roles)
                                                    @foreach ($companyItem->user->roles as $role)
                                                    @if ($role->name === 'kuliner' || $role->name === 'wisata')
                                                            <option value="{{ $companyItem->id }}">{{ $companyItem->nama }}|{{ $companyItem->user->email }} |{{ $role->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="active">Status</label>
                                        <select name="active" class="form-control" required>
                                            <option value="1" {{ $kuliner->active == '1' ? 'selected':'' }}>Publish</option>
                                            <option value="0" {{ $kuliner->active == '0' ? 'selected':'' }}>Draft</option>
                                        </select>
                                        
                                        <p class="text-danger">{{ $errors->first('active') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="categorykuliner_id">Kategori</label>
                                        <select class="form-control" name="categorykuliner_id" required>
                                            <option value="{{$kuliner->categorykuliner_id}}"  {{ $kuliner->categorykuliner_id != "" ? 'selected' : '' }}>{{$kuliner->getcategory->category_name}}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('categorykuliner_id', $kuliner->categorykuliner_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger">{{ $errors->first('categorykuliner_id') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Instagram</label>
                                        <input class="form-control" name="instagram" id="instagram" value="{{ $kuliner->instagram }}" required>
                                        <p class="text-danger">{{ $errors->first('instagram') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="weight">Website</label>
                                        <input class="form-control" name="web" id="web" value="{{ $kuliner->web }}"  required>
                                        <p class="text-danger">{{ $errors->first('web') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="weight">Telpon</label>
                                    <input class="form-control" name="telpon" id="telpon" value="{{ $kuliner->telpon }}" required>
                                        <p class="text-danger">{{ $errors->first('telpon') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="jambuka">Buka</label>
                                        <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" name="jambuka" value="{{ $kuliner->jambuka }}" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jamtutup">Tutup</label>
                                        <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" name="jamtutup" value="{{ $kuliner->jamtutup }}" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kapasitas">Kapasitas</label>
                                        <div >
                                            <input class="form-control" type="text" name="kapasitas" id="kapasitas" value="{{ $kuliner->kapasitas }}" required>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                            
                                  
                                    

                                    <div class="mapform" >
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                Alamat 
                                                <div >
                                                    <input class="form-control" type="text" name="alamat" id="alamat" value="{{ $kuliner->alamat }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                Kecamatan 
                                                <div >
                                                    <select class="form-control" name="kecamatan_id" required>
                                                        <option value="{{$kuliner->kecamatan_id}}"  {{ $kuliner->kecamatan_id != "" ? 'selected' : '' }}>{{$kuliner->kecamatan->Kecamatan}}</option>
                                                        @foreach($kecamatan as $kecamatan)
                                                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $kuliner->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                                                {{ $kecamatan->Kecamatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                Latitude
                                                <input type="text" class="form-control" placeholder="latitude" name="latitude" id="lat" value="{{ $kuliner->latitude }}" required>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                            longitude
                                                <input type="text"  class="form-control" placeholder="longitude" name="longitude" id="lng" value="{{ $kuliner->longitude }}" required>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div id="map" style="height: 600px; width: 100%; position: relative; overflow: hidden;"  class="my-3"></div>

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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script>
        let map;
        let cityPoligon;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat:  {{ $kuliner->latitude }} , lng: {{ $kuliner->longitude }}  },
            zoom: 8,
            scrollwheel: true,
        });
        map.data.loadGeoJson('/js/Kuninganbatas.geojson');
        const uluru = { lat: {{ $kuliner->latitude }}  , lng: {{ $kuliner->longitude }}  };
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
    url: '{{ route('admin.kuliner.storeMedia') }}',
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
@if(isset($kuliner) && $kuliner->photos)
      var files =
        {!! json_encode($kuliner->photos) !!}
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