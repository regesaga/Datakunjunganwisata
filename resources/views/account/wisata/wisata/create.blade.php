@extends('layouts.author.account')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            Detail Obyek Wisata
        </div>
        <div class="card-body">
            <form action="{{route('account.wisata.wisata.storeWisata')}}"  method="post" enctype="multipart/form-data" onsubmit="return validateForm()" >
                @csrf
                        
                        {{-- <iframe width="100%" height="500" src="https://maps.google.com/maps?q=kuningan&output=embed"></iframe>  --}}
                        
                                <div class="row">
                                    
                                    <div class="col-lg-6 col-md-6">
                                        Nama Wisata 
                                        <div >
                                            <input class="form-control" type="text" name="namawisata" id="namawisata" value="{{ old('namawisata', '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        Category 
                                        <div >
                                            
                                            <select class="form-control" name="categorywisata_id" value="{{ old('categorywisata_id') }}" required>
                                                @foreach($categories as $category)
                                              <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
            
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        Kapasitas
                                        <div >
                                            <input class="form-control" type="text" name="kapasitas" id="kapasitas" value="{{ old('kapasitas', '') }}" required>
                                        </div>
                                    </div>
                                  
                                </div>
                                <br>
                                <div class="row">
                                    
                                    <div class="col-lg-6 col-md-6">
                                        Deskripsi
                                        <div >
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea>
                                        </div>
                                    </div>
                                                                            
                                    <div class="col-lg-6 col-md-6">
                                        Photo Wisata
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
                                    <div class="col-lg-2 col-md-2">
                                        Telphone 
                                        <div >
                                            <input class="form-control" name="telpon" id="telpon" value="{{ old('telpon', '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        Buka 
                                        <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" name="jambuka" value="{{ old('jambuka', '') }}" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        Tutup 
                                        <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" name="jamtutup" value="{{ old('jamtutup', '') }}" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    {{-- <div class="col-lg-1 col-md-1">
                                        Status Aktif  
                                        <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                                            <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">{{ trans('Ceklis Jika Wisata Sudah terverifikasi dan Aktif') }}</label>
                                        </div>
                                        @if($errors->has('active'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('active') }}
                                            </div>
                                        @endif
                                    </div> --}}
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <label class="required" for="kategori">Jenis</label>
                                        <input type="text" class="form-control" name="kategori[]" value="{{ old('kategori') }}"required>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label class="required" for="harga">Harga</label>
                                        <input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required name="harga[]" value="{{ old('harga') }}"required>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-8">
                                            <a href="#" class="addtiket btn btn-primary" style="float: right;">Tambah Harga Tiket</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tiket"></div>
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

                                <div class="mapform" >
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            Alamat 
                                            <div >
                                                <input class="form-control" type="text" name="alamat" id="alamat" value="{{ old('alamat', '') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
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
           url: '{{ route('account.wisata.wisata.storeMedia') }}',
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
                @if(isset($wisata) && $wisata->photos)
                var files =
                {!! json_encode($wisata->photos) !!}
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
      '<div><div class="row"><div class="col-lg-4 col-md-4"><label class="required" for="kategori">Jenis</label><input type="text" class="form-control" name="kategori[]" required></div><div class="col-lg-2 col-md-2"><label class="required" for="harga">Harga</label><input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required class="form-control" name="harga[]" required></div><div class="col-lg-4 col-md-4"><label class="col-sm-2 col-form-label"></label><div class="col-sm-8"> <a href="#" class="remove btn btn-danger" style="float: right;">Hapus</a></div></div></div><div>';
    $('.tiket').append(tiket);
  }

  $(document).on('click', '.remove', function() {
    $(this).parent().parent().parent().remove();
  });
</script>
@endpush


@endsection







