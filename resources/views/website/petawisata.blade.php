@extends('layouts.website.main')


@section('content')
    <style>
        #map-canvas {
            height: 70%;
            width: 70%;
            margin: 0 auto 0 auto;
        }

        .map-icon-label .map-icon {
            font-size: 12px;
            color: #FFFFFF;
            text-align: center;
            white-space: nowrap;
        }

        html,
        body {
            height: 100%;
        }

.customMarker.wisata {
  position: absolute;
  cursor: pointer;
  background: rgba(251, 200, 83, 255);
  width: 60px;
  height: 60px;
  left: /* koordinat geografis absolut */;
    top: /* koordinat geografis absolut */;
    transform: translate(-50%, -50%);
  border-radius: 80%;
  padding: 0px;
}

.customMarker.kuliner {
  position: absolute;
  cursor: pointer;
  background: rgba(184, 215, 98, 255);
  width: 60px;
  height: 60px;
  left: /* koordinat geografis absolut */;
    top: /* koordinat geografis absolut */;
    transform: translate(-50%, -50%);
  border-radius: 80%;
  padding: 0px;
}

.customMarker.akomodasi {
  position: absolute;
  cursor: pointer;
  background: rgba(236, 111, 55, 255);
  width: 60px;
  height: 60px;
  left: /* koordinat geografis absolut */;
    top: /* koordinat geografis absolut */;
    transform: translate(-50%, -50%);
  border-radius: 80%;
  padding: 0px;
}

.customMarker.wisata:after,
.customMarker.kuliner:after,
.customMarker.akomodasi:after {
  content: "";
  position: absolute;
  bottom: -10px;
  left: 20px;
  border-width: 10px 10px 0;
  border-style: solid;
  display: block;
  width: 0;
}

.customMarker.wisata:after {
  border-color: rgba(251, 200, 83, 255) transparent;
}

.customMarker.kuliner:after {
  border-color: rgba(184, 215, 98, 255) transparent;
}

.customMarker.akomodasi:after {
  border-color: rgba(236, 111, 55, 255) transparent;
}


        .customMarker img {
            width: 50px;
            height: 50px;
            margin: 5px;
            border-radius: 50%;
        }
        .customMarker:hover {
    transform: translate(-50%, -50%) scale(1.2);
}

.customMarker:hover img {
    transform: scale(1.2);
}

        #map {
            height: 1200px;
            width: 100%;
            position: relative;
            overflow: auto;
        }

        .text-container {
            width: 150px;
            /* Atur lebar elemen sesuai kebutuhan */
            /* Menampilkan tanda elipsis (...) jika teks melebihi lebar */
        }
    </style>

    {{-- <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="home-slider owl-carousel js-fullheight">
            @foreach ($baner as $banerItem)
                <div class="slider-item js-fullheight"
                    style="background-image:url('{{ asset('upload/banner/' . $banerItem->sampul) }}');">
                    <div class="container">
                        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">

                            <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" class="img-fluid animated"
                                style="max-height: 200px; width: auto ;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section><!-- End Hero --> --}}

        <!-- ======= Peta Wisata ======= -->

        <div id="map"></div>
        <div>
            <h2 style="color: #3a6a6e;">
                <div class="d-flex justify-content-center">
                    <label class="" for="jenis">{{ __('messages.type') }}</label>
                    <select id="jenis" onchange="filterMarkers()">
                        <option value="all">{{ __('messages.all') }}</option>
                        <option value="wisata">{{ __('messages.tour') }}</option>
                        <option value="kuliner">{{ __('messages.culinary') }}</option>
                        <option value="akomodasi">{{ __('messages.accommodation') }}</option>
                    </select>
                </div>
            </h2>
        </div>
        

        <script>
            var wisataData = {!! $wisataData !!};
        </script>

<script>
    var kulinerData = {!! $kulinerData !!};
</script>
<script>
    var akomodasiData = {!! $akomodasiData !!};
</script>


    <!-- ======= Footer ======= -->
    @include('layouts.website.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
            @push('javascript-bottom')
            @include('java_script.petawisata.script')
        @endpush
    @endsection
    