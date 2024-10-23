@extends('layouts.website.main')

@section('content')
    <!-- ======= Hero Section ======= -->
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
    </section>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                    <ol>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>{{ __('messages.Event') }}</li>
                    </ol>
            </div>

        </section><!-- End Breadcrumbs -->
        <?php
        $tanggalMulai = date('d F Y H:i', strtotime($event->tanggalmulai));
        $tanggalMulai = strtr($tanggalMulai, __('messages'));
        $tanggalMulai = strtr($tanggalMulai, __('messages'));
        $tanggalMulai = mb_convert_case($tanggalMulai, MB_CASE_UPPER, 'UTF-8');
        $tanggalSelesai = date('d F Y H:i', strtotime($event->tanggalselesai));
        $tanggalSelesai = strtr($tanggalSelesai, __('messages'));
        $tanggalSelesai = strtr($tanggalSelesai, __('messages'));
        $tanggalSelesai = mb_convert_case($tanggalSelesai, MB_CASE_UPPER, 'UTF-8');
        $dateCurrent = now()->format('Y-m-d H:i:s');
        ?>

        <!-- ======= Wisata Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-7">
                        <div class="portfolio-details-slider swiper">
                           

                            <div class="swiper-wrapper align-items-center">
                                {{-- @foreach ($event->photos as $key => $media) --}}
                                {{-- <div class="swiper-slide"> --}}
                                @foreach ($event->photos as $key => $media)
                                    <div class="swiper-slide">
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                        <img src="{{ $media->getUrl() }}" alt="Foto">
                                        </a>
                                    </div>
                                @endforeach

                                {{-- </div> --}}
                                {{-- @endforeach --}}
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <div class="portfolio-description">
                            <b>
                                {{ $event->title }}
                            </b>
                        </div>

                        <div data-v-c78794cc="" style="color: rgb(126, 130, 153);"
                            class="d-flex flex-wrap align-items-center">
                            <div data-v-c78794cc="" class="mb-2"><svg data-v-c78794cc="" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path data-v-c78794cc=""
                                        d="M19 4H18V2H16V4H8V2H6V4H5C3.89 4 3.01 4.9 3.01 6L3 20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V10H19V20ZM19 8H5V6H19V8ZM12 13H17V18H12V13Z"
                                        fill="#7E8299"></path>
                                </svg>  {{ $tanggalMulai }} - {{ $tanggalSelesai }}
                            </div>
                            @php
                            $today = now()->format('Y-m-d');
                                @endphp
                                
                                @if ($event->tanggalselesai <= $today && $event->tanggalselesai < $today)
                                    <span style="background: rgb(241, 65, 108); color: rgb(255, 255, 255); border-radius: 10px;" class="px-3 py-1 ms-3 mb-2">
                                        {{ __('messages.eventEnd') }}
                                    </span>
                                @else
                                    <span style="background: rgb(65, 200, 241); color: rgb(255, 255, 255); border-radius: 10px;" class="px-3 py-1 ms-3 mb-2">
                                        {{ __('messages.eventStart') }}
                                    </span>
                                @endif
                        </div>
                     <div class="portfolio-description">
                            <p>
                                 {!! $event->deskripsi !!}
                            </p>
                        </div> 
                    </div>


                    <div class="col-lg-5">
                       
                            
                           
                            <div class="card card-primary">
                                <div class="card-header">
                                  <h3 class="card-title">{{ __('messages.Event') }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                 
                  
                                  <strong><i class="fas fa-map-marker-alt mr-1"></i> {{ __('messages.address') }}</strong>
                  
                                  <p class="text-muted">{{ $event->lokasi }}</p>
                  
                                  <hr>
                  
                                 
                            <div class="cuaca-box">
                                <span>{{ $weatherData['name'] }}</span>
                                <br>
                                <img src="{{ asset('icon/cuaca_icons/' . $imageName) }}" width="85px">
                                <br>
                                <span>{{ __('messages.' . $weatherData['weather'][0]['icon']) }}</span>
                                <br>
                                <i class="fas fa-temperature-high"></i> {{ $temperatureCelsius }}<sup>C</sup>
                                <br>
                                <i class="fas fa-wind"></i> {{ $windSpeedMeterPerSecond }} m/s
                                <br>
                            </div>
                        </div>
                           
                        
                            <iframe style="height: 250px; width: 400PX; position: relative; overflow: hidden;"
                            src="https://maps.google.com/maps?q={{ $event->latitude }},{{ $event->longitude }}&output=embed"></iframe>
                            <a 
                                href="https://www.google.com/maps/dir/?api=1&destination={{ $event->latitude }},{{ $event->longitude }}"
                                class="btn btn-outline-map text-white text-center w-100 fs-15px mt-3"
                                style="border-radius: 15px; padding: 15px;"onclick="arahkanSaya('{{ $event->latitude }}', '{{ $event->longitude }}')">{{ __('messages.directMe') }}</button></a>

                          </div>


                </div>

        </section><!-- End Portfolio Details Section -->

    </main>

    <!-- ======= Footer ======= -->
    @include('layouts.website.container')
    @include('layouts.website.footer')

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
@endsection
