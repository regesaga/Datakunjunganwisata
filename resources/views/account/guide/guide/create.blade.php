@extends('layouts.author.account')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            Detail Tour Guide
        </div>
        <div class="card-body">
            <form action="{{route('account.guide.guide.storeGuide')}}"  method="post" enctype="multipart/form-data"  onsubmit="return validateForm()">
                @csrf
                        
                        {{-- <iframe width="100%" height="500" src="https://maps.google.com/maps?q=kuningan&output=embed"></iframe>  --}}
                        
                        <div class="row">
                            
                            <div class="col-lg-6 col-md-6">
                                Nama Paket Wisata 
                                <div >
                                    <input class="form-control" type="text" name="namapaketwisata" id="namapaketwisata" value="{{ old('namapaketwisata', '') }}" required>
                                </div>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            
                            <div class="col-lg-6 col-md-6">
                                Kegiatan
                                <div >
                                    <textarea class="form-control" name="kegiatan" id="deskripsi" required>{{ old('kegiatan') }}</textarea>
                                </div>
                            </div>
                                                                    
                            <div class="col-lg-6 col-md-6">
                                Photo Tour Guide
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
                                    <textarea class="form-control" name="htm" id="deskripsi1" required>{{ old('htm') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                Harga Tidak termasuk
                                <div >
                                    <textarea class="form-control" name="nohtm" id="deskripsi2" required>{{ old('nohtm') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                Destinasi Wisata
                                <div >
                                    <textarea class="form-control" name="destinasiwisata" id="deskripsi3" required>{{ old('destinasiwisata') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                Contact Person
                                <div >
                                    <textarea class="form-control" name="telpon" id="telpon" required>{{ old('telpon') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-2">
                                <label class="required" for="jenis">Jenis</label>
                                <input type="text" class="form-control" name="jenis[]" value="{{ old('jenis') }}"required>
                            </div>
                            <div class="col-lg-2 col-md-2">
                                <label class="required" for="harga">Harga</label>
                                <input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required name="harga[]" value="{{ old('harga') }}"required>
                            </div>

                            <div class="col-lg-4 col-md-4">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <a href="#" class="addtiket btn btn-primary" style="float: right;">Tambah Harga Paket</a>
                                </div>
                            </div>
                        </div>
                        <div class="tiket"></div>
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
  var deskripsi1 = document.getElementById("deskripsi1").value;
  var deskripsi2 = document.getElementById("deskripsi2").value;
  var deskripsi3 = document.getElementById("deskripsi3").value;

  if (deskripsi.trim() === "") {
    alert("Kegiatan Termasuk harus diisi, Jika sudah diisi silahkan submit lagi");
    return false;
  }

  if (deskripsi1.trim() === "") {
    alert(" harga termasuk harus diisi, Jika sudah diisi silahkan submit lagi");
    return false;
  }

  if (deskripsi2.trim() === "") {
    alert(" Harga Tidak termasuk  harus diisi, Jika sudah diisi silahkan submit lagi");
    return false;
  }

  if (deskripsi3.trim() === "") {
    alert("Destinasi  harus diisi, Jika sudah diisi silahkan submit lagi");
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
           url: '{{ route('account.guide.guide.storeMedia') }}',
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
                @if(isset($guide) && $guide->photos)
                var files =
                {!! json_encode($guide->photos) !!}
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
        '<div><div class="row"><div class="col-lg-2 col-md-2"><label class="required" for="jenis">Jenis</label><input type="text" class="form-control" name="jenis[]" required></div><div class="col-lg-2 col-md-2"><label class="required" for="harga">Harga</label><input type="number" class="form-control" pattern="[0-9]+" title="Masukkan angka" required class="form-control" name="harga[]" required></div><div class="col-lg-2 col-md-2"><label class="col-sm-2 col-form-label"></label><div class="col-sm-8"> <a href="#" class="remove btn btn-danger" style="float: right;">Hapus</a></div></div></div><div>';
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

@endpush


@endsection







