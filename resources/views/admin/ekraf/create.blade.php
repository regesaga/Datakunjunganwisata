@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Ekraf</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-12">
    <div class="card">
        <div class="card-header">
            Tambah Pelaku Ekraf
        </div>
        <div class="card-body">
            <form action="{{route('admin.ekraf.storeEkraf')}}"  method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                        
                        {{-- <iframe width="100%" height="500" src="https://maps.google.com/maps?q=kuningan&output=embed"></iframe>  --}}
                        
                                <div class="row">
                                    
                                    <div class="col-lg-6 col-md-6">
                                        Nama Pelaku Ekraf 
                                        <div >
                                            <input class="form-control" type="text" name="namaekraf" id="namaekraf" value="{{ old('namaekraf', '') }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-2 col-md-2">
                                        Sub Sektor Ekraf
                                        <div >
                                            
                                            <select class="form-control" name="sektorekraf_id" value="{{ old('sektorekraf_id') }}" required>
                                                @foreach($sektorekraf as $sektorekraf)
                                              <option value="{{$sektorekraf->id}}">{{$sektorekraf->sektor_name}}</option>
                                                @endforeach
                                            </select>
            
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1"style="display: none;">
                                        inpus sebagai
                                        <div >
                                            <select class="form-control" name="company_id" value="{{ old('company_id') }}" required>
                                                @foreach($company as $company)
                                            <option value="1">{{$company->nama}}</option>
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
                                        Photo Ekraf
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
                                            <input class="form-control" name="instagram" id="instagram" value="{{ old('instagram', '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        Website 
                                        <div >
                                            <input class="form-control" name="web" id="web" value="{{ old('web', '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1">
                                        Telphone 
                                        <div >
                                            <input class="form-control" name="telpon" id="telpon" value="{{ old('telpon', '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1">
                                        <label for="active">Status</label>
                                        <select name="active" class="form-control" required>
                                            <option value="1" {{ old('active') == '1' ? 'selected':'' }}>Publish</option>
                                            <option value="0" {{ old('active') == '0' ? 'selected':'' }}>Draft</option>
                                        </select>
                                        <p class="text-danger">{{ $errors->first('active') }}</p>
                                    </div> 
                                   
                                </div>
                              
                                <br>

                                <div class="mapform" >
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            Alamat 
                                            <div >
                                                <input class="form-control" type="text" name="alamat" id="alamat" value="{{ old('alamat', '') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            Kecamatan 
                                            <div >
                                                
                                                <select class="form-control" name="kecamatan_id" value="{{ old('kecamatan_id') }}" required>
                                                    @foreach($kecamatan as $kecamatan)
                                                  <option value="{{$kecamatan->id}}">{{$kecamatan->Kecamatan}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            Latitude
                                            <input type="text" class="form-control" placeholder="latitude" name="latitude" id="lat" required>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                           longitude
                                            <input type="text"  class="form-control" placeholder="longitude" name="longitude" id="lng" required>
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
    let map;
    let cityPoligon;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -7.013805, lng: 108.570064 },
            zoom: 12,
            scrollwheel: true,
            mapTypeId: google.maps.MapTypeId.HYBRID
        });
      map.data.loadGeoJson('/js/Kuninganbatas.geojson');

        const uluru = { lat: -7.013805, lng: 108.570064 };
        let marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable: true
        });

        google.maps.event.addListener(marker,'position_changed',
            function (){
                
                let lat = marker.position.lat()
                let lng = marker.position.lng()
                $('#lat').val(lat)
                $('#lng').val(lng)
            })

        google.maps.event.addListener(map,'click',
        function (event){
            pos = event.latLng
            marker.setPosition(pos)
        })


  
        
    }
</script>

<script>

 
     
  </script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_UNRESTRICTED') }}&callback=initMap" ></script>

{{-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" ></script> --}}
	<script src="/admin/dist/bootstrap-clockpicker.min.js"></script>
    
<script src="/js/mapInput.js"></script>
<script type="text/javascript">
    $('.clockpicker').clockpicker();
    </script>
<script>
   var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('admin.ekraf.storeMedia') }}',
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
@if(isset($ekraf) && $ekraf->photos)
      var files =
        {!! json_encode($ekraf->photos) !!}
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






</body>






