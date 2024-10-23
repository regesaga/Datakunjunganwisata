@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Even Calender</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
            Edit Obyek Wisata
            </div>
            <form method="POST" action="{{ route("admin.evencalender.update", $hash->encodeHex($evencalender->id)) }}"   enctype="multipart/form-data" >
                @method('PUT')
                @csrf
                <div class="table-responsive">
                   
                    <table class="table table-bordered table-striped table-hover">
                        <tbody class="tiket">
                        
                        {{-- <iframe width="100%" height="500" src="https://maps.google.com/maps?q=kuningan&output=embed"></iframe>  --}}
                        
                        <tr>
                            <th width="10%">
                                Nama Even
                            </th>
                            <td>
                                            <input class="form-control" type="text" name="title" id="title" value="{{ $evencalender->title }}" required>
                            </td>
                        </tr>
                        <tr>
                            <th width="10%">
                                Deskripsi
                            </th>
                            <td>
                                        <textarea class="form-control " name="deskripsi" id="deskripsi">{{ $evencalender->deskripsi}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Photo Event
                            </th>
                            <td>
                                    
                                                                               
                                            <div class="needsclick dropzone" {{ $errors->has('photos') ? 'is-invalid' : '' }} id="photos-dropzone">
                            </td>
                        </tr>
                
                       
                      
                      <tr>
                            <th>
                            Waktu di mulai dan selesai 
                            </th>
                            <td>
                                <div class="row">
                                    <div class="col-lg-2 col-md-2">
                                        Waktu Mulai 
                                        <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" name="jammulai" value="{{ $evencalender->jammulai}}" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        Waktu Selesai 
                                        <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" name="jamselesai" value="{{ $evencalender->jamselesai}}" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        Tanggal Mulai
                                        <div class="input-group" data-align="top" data-autoclose="true">
                                            <input type="date" class="form-control" id="tanggalmulai" name="tanggalmulai" value="{{ date('Y-m-d', strtotime($evencalender->tanggalmulai)) }}" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        Tanggal Selesai
                                        <div class="input-group" data-align="top" data-autoclose="true">
                                            <input type="date" class="form-control" id="tanggalselesai" name="tanggalselesai" value="{{ date('Y-m-d', strtotime($evencalender->tanggalselesai)) }}" required onchange="checkEndDate()">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-2 col-md-2">
                                        Status   
                                        <select name="active" class="form-control" required>
                                            <option value="1" {{ $evencalender->active == '1' ? 'selected':'' }}>Publish</option>
                                            <option value="0" {{ $evencalender->active == '0' ? 'selected':'' }}>Draft</option>
                                        </select>
                                        
                                        @if($errors->has('active'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('active') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Lokasi dan Map
                            </th>
                            <td>
                                <div class="mapform" >
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            Lokasi 
                                            <div >
                                                <input class="form-control" type="text" name="lokasi" id="lokasi" value="{{ $evencalender->lokasi}}" required>
                                            </div>
                                        </div>
                                      
                                        <div class="col-lg-2 col-md-2">
                                            <label class="required" for="latitude">Latitude</label>
                                            <input type="text" class="form-control" placeholder="latitude" name="latitude" id="lat" value="{{ $evencalender->latitude}}">
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <label class="required" for="longitude">longitude</label>
                                            <input type="text"  class="form-control" placeholder="longitude" name="longitude" id="lng" value="{{ $evencalender->longitude}}">
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <div id="map" style="height: 600px; width: 100%; position: relative; overflow: hidden;"  class="my-3"></div>

                            </td>
                        </tr>
                       
                    </tbody>
                </table>
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
</main>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script>
        let map;
        let cityPoligon;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat:  {{ $evencalender->latitude }} , lng: {{ $evencalender->longitude }}  },
            zoom: 8,
            scrollwheel: true,
        });
        map.data.loadGeoJson('/js/Kuninganbatas.geojson');
        const uluru = { lat: {{ $evencalender->latitude }}  , lng: {{ $evencalender->longitude }}  };
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
    url: '{{ route('admin.evencalender.storeMedia') }}',
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
@if(isset($evencalender) && $evencalender->photos)
      var files =
        {!! json_encode($evencalender->photos) !!}
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '.addtiket', function() {
        addtiket();
    });

    function addtiket() {
        var tiket =
        '<div class="row"><div class="col-lg-2 col-md-2"><label class="required" for="kategori">Jenis</label><input type="text" class="form-control" name="kategori[]" value="{{ old('kategori') }}"required></div><div class="col-lg-2 col-md-2"><label class="required" for="harga">Harga</label><input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required class="form-control" name="harga[]" value="{{ old('harga') }}"required></div><div class="col-lg-2 col-md-2"><label class="col-sm-2 col-form-label"></label><div class="col-sm-8"> <a href="#" class="remove btn btn-danger" style="float: right;">Hapus</a></div></div></div>';
        $('.tiket').append(tiket);
    };

    $(document).on('click', '.remove', function() {
        $(this).closest('td').remove();
    });
</script>
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('deskripsi');
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>

