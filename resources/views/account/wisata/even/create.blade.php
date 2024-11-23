@extends('layouts.author.account')
@section('content')
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Tambah Even
                        </div>
                        <form action="{{ route('account.wisata.even.storeEven') }}" method="post"
                            enctype="multipart/form-data" onsubmit="return validateForm()">
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
                                                <input class="form-control" type="text" name="title" id="title"
                                                    value="{{ old('title', '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="10%">
                                                Deskripsi
                                            </th>
                                            <td>
                                                <textarea class="form-control " name="deskripsi" id="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Photo Event
                                            </th>
                                            <td>
                                                <div class="needsclick dropzone"
                                                    {{ $errors->has('photos') ? 'is-invalid' : '' }} id="photos-dropzone">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Waktu di mulai dan selesai
                                            </th>
                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3">
                                                        Waktu Mulai
                                                        <div class="input-group clockpicker" data-align="top"
                                                            data-autoclose="true">
                                                            <input type="text" class="form-control" name="jammulai"
                                                                value="{{ old('jammulai', '') }}" required>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-time"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3">
                                                        Waktu Selesai
                                                        <div class="input-group clockpicker" data-align="top"
                                                            data-autoclose="true">
                                                            <input type="text" class="form-control" name="jamselesai"
                                                                value="{{ old('jamselesai', '') }}" required>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-time"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3">
                                                        Tanggal Mulai
                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                            <input type="date" class="form-control" id="tanggalmulai" name="tanggalmulai" value="{{ old('tanggalmulai', '') }}" required>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-time"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3">
                                                        Tanggal Selesai
                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                            <input type="date" class="form-control" id="tanggalselesai" name="tanggalselesai" value="{{ old('tanggalselesai', '') }}" required onchange="checkEndDate()">
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-time"></span>
                                                            </span>
                                                        </div>
                                                    </div>

                                                  
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Lokasi dan Map
                                            </th>
                                            <td>
                                                <div class="mapform">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            Lokasi
                                                            <div>
                                                                <input class="form-control" type="text" name="lokasi"
                                                                    id="lokasi" value="{{ old('lokasi', '') }}"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-4">
                                                            Latitude
                                                            <input type="text" class="form-control"
                                                                placeholder="latitude" name="latitude" id="lat" required>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            longitude
                                                            <input type="text" class="form-control"
                                                                placeholder="longitude" name="longitude" id="lng" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="map"
                                                    style="height: 600px; width: 100%; position: relative; overflow: hidden;"
                                                    class="my-3">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <input type="submit" class="btn btn-outline-success btn-sm form-control" value="Submit">
                            </div>
                        </form>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script>
        let map;
        let cityPoligon;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: -7.013805,
                    lng: 108.570064
                },
                zoom: 12,
                scrollwheel: true,
                mapTypeId: google.maps.MapTypeId.HYBRID
            });
            map.data.loadGeoJson('/js/Kuninganbatas.geojson');

            const uluru = {
                lat: -7.013805,
                lng: 108.570064
            };
            let marker = new google.maps.Marker({
                position: uluru,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'position_changed',
                function() {

                    let lat = marker.position.lat()
                    let lng = marker.position.lng()
                    $('#lat').val(lat)
                    $('#lng').val(lng)
                })

            google.maps.event.addListener(map, 'click',
                function(event) {
                    pos = event.latLng
                    marker.setPosition(pos)
                })

        }
    </script>

    <script></script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_UNRESTRICTED') }}&callback=initMap"></script>

    {{-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" ></script> --}}
    <script src="/admin/dist/bootstrap-clockpicker.min.js"></script>

    <script src="/js/mapInput.js"></script>
    <script type="text/javascript">
        $('.clockpicker').clockpicker();
    </script>
    <script>
        // Fungsi untuk memeriksa tanggal selesai lebih besar dari tanggal mulai
        function checkEndDate() {
            var startDate = document.getElementById("tanggalmulai").value;
            var endDate = document.getElementById("tanggalselesai").value;

            if (endDate < startDate) {
                alert("Tanggal selesai harus lebih besar dari tanggal mulai");
                document.getElementById("tanggalselesai").value = ""; // Kosongkan nilai tanggal selesai
                return false;
            }
            return true;
        }
        $('#tanggalmulai').change(function() {
            $('#tanggalselesai').val('')
        })

        var uploadedPhotosMap = {}
        Dropzone.options.photosDropzone = {
            url: '{{ route('account.wisata.even.storeMedia') }}',
            maxFilesize: 8, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif,.mp4',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 8,
                width: 6096,
                height: 6096
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
                uploadedPhotosMap[file.name] = response.name
            },
            removedfile: function(file) {
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
            init: function() {
                @if (isset($evencalender) && $evencalender->photos)
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
            error: function(file, response) {
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

@endpush


@endsection
