@extends('layouts.author.account')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Edit Kuliner
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("account.ekraf.ekraf.update",$ekraf->id) }}"    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                                
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            Nama Pelaku Ekraf 
                            <div >
                                <input class="form-control" type="text" name="namaekraf" id="namaekraf"  value="{{ $ekraf->namaekraf }}" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            Sub Sektor
                            <div>
                                <select class="form-control" name="sektorekraf_id" required>
                                    <option value="{{$ekraf->sektorekraf_id}}"  {{ $ekraf->sektorekraf_id != "" ? 'selected' : '' }}>{{$ekraf->getSektor->sektor_name}}</option>
                                    @foreach($sektorekraf as $sektorekraf)
                                        <option value="{{ $sektorekraf->id }}" {{ old('sektorekraf_id', $ekraf->sektorekraf_id) == $sektorekraf->id ? 'selected' : '' }}>
                                            {{ $sektorekraf->sektor_name }}
                                        </option>
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
                                <textarea class="form-control " name="deskripsi" id="deskripsi">{{ $ekraf->deskripsi }}</textarea>
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
                        <div class="col-lg-5 col-md-5">
                            Instagram 
                            <div >
                                <input class="form-control" name="instagram" id="instagram"  value="{{ $ekraf->instagram }}" required>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5">
                            Website 
                            <div >
                                <input class="form-control" name="web" id="web"  value="{{ $ekraf->web }}" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            Telphone 
                            <div >
                                <input class="form-control" name="telpon" id="telpon"  value="{{ $ekraf->telpon }}" required>
                            </div>
                        </div>
                       
                        
                    </div>
                    
                   <br>


                    <div class="mapform" >
                        <div class="row">
                            <div class="col-lg-5 col-md-5">
                                Alamat 
                                <div >
                                    <input class="form-control" type="text" name="alamat" id="alamat" value="{{ $ekraf->alamat }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                Kecamatan 
                                <div >
                                    <select class="form-control" name="kecamatan_id" required>
                                        <option value="{{$ekraf->kecamatan_id}}"  {{ $ekraf->kecamatan_id != "" ? 'selected' : '' }}>{{$ekraf->kecamatan->Kecamatan}}</option>
                                        @foreach($kecamatan as $kecamatan)
                                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $ekraf->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                                {{ $kecamatan->Kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2">
                                Latitude
                                <input type="text" class="form-control" placeholder="latitude" name="latitude" id="lat" value="{{ $ekraf->latitude }}" required>
                            </div>
                            <div class="col-lg-2 col-md-2">
                            longitude
                                <input type="text"  class="form-control" placeholder="longitude" name="longitude" id="lng" value="{{ $ekraf->longitude }}" required>
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
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
      <script>
          CKEDITOR.replace('deskripsi');
      </script>
    <script>
        let map;
        let cityPoligon;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat:  {{ $ekraf->latitude }} , lng: {{ $ekraf->longitude }}  },
            zoom: 8,
            scrollwheel: true,
        });
        map.data.loadGeoJson('/js/Kuninganbatas.geojson');
        const uluru = { lat: {{ $ekraf->latitude }}  , lng: {{ $ekraf->longitude }}  };
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
    url: '{{ route('account.ekraf.ekraf.storeMedia') }}',
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

<script type="text/javascript">
    $(document).on('click', '.addtiket', function() {
      addtiket();
    });
  
    function addtiket() {
      var tiket =
        '<div><div class="row"><div class="col-lg-2 col-md-2"><label class="required" for="kategori">Jenis</label><input type="text" class="form-control" name="kategori[]"  value="{{ old('kategori') }}" required></div><div class="col-lg-2 col-md-2"><label class="required" for="harga" value="{{ old('harga') }}">Harga</label><input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required class="form-control" name="harga[]" required></div><div class="col-lg-2 col-md-2"><label class="col-sm-2 col-form-label"></label><div class="col-sm-8"> <a href="#" class="remove btn btn-danger" style="float: right;">Hapus</a></div></div></div><div>';
      $('.tiket').append(tiket);
    }
  
    $(document).on('click', '.remove', function() {
      $(this).parent().parent().parent().remove();
    });
  </script>
  @endpush


  @endsection
  
  

