<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Kuningan Beu</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('images/logo/KuninganBeu.png') }}" rel="icon">
    <link href="{{ asset('images/logo/KuninganBeu_Kuning.png') }}" rel="apple-touch-icon">
    <!-- Online -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->

    <link href="{{ asset('Frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('Frontend/assets/css/slick-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/css/style.mobile.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('Frontend/assets/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('Frontend/assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('Frontend/assets/css/owl.carousel2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('Frontend/assets/css/owl.carousel3.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('Frontend/assets/css/owl.carousel4.min.css') }}" rel="stylesheet" type="text/css">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">

    <style>
        .language-dropdown ul {
            display: none;
            position: absolute;
            background-color: #fff;
            /* Ganti dengan warna yang diinginkan */
            padding: 10px;
            border: 1px solid #ccc;
            /* Ganti dengan warna yang diinginkan */
        }

        .language-dropdown ul li a {
            color: #000;
            /* Teks menjadi hitam */
            text-decoration: none;
            /* Menghapus garis bawah */
        }

        .language-dropdown:hover ul {
            display: block;
        }
        .tabcuaca {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}
.tabcuaca button {
  background-color: rgba(236,111,55,255);
  color: white;
  border: none;
  padding: 10px 15px;
  margin: 0 5px;
  cursor: pointer;
  border-radius: 5px;
}
.tabcuaca button.active {
  background-color: rgba(251,200,83,255);
}
.weather-containercuaca {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
  margin: 20px 0;
}
.weather-cardcuaca {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  width: 150px;
  text-align: center;
}
.weather-cardcuaca img {
  width: 50px;
  height: 50px;
}
.temperature {
  font-size: 24px;
  font-weight: bold;
  margin: 10px 0;
}
.descriptioncuaca {
  margin: 5px 0;
  color: #555;
}
.infocuaca {
  font-size: 14px;
  color: #777;
}
.timecuaca {
  font-size: 12px;
  color: #aaa;
}
    </style>
</head>

<body>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '3173188249481354',
                xfbml: true,
                version: 'v19.0'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <header id="header" class="fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="logo me-auto">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" alt=""
                        style="height: 100px; width: auto; margin-right: 3px;">
                </a>
            </h1>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class=" scrollto" href="{{ route('website.articel') }}">{{ __('messages.articel') }}</a>
                    </li>
                    <li><a class=" scrollto" href="{{ route('website.destinasi') }}">{{ __('messages.tour') }}</a>
                    </li>
                    <li><a class=" scrollto" href="{{ route('website.kuliner') }}">{{ __('messages.culinary') }}</a>
                    </li>
                    <li><a class=" scrollto"
                            href="{{ route('website.akomodasi') }}">{{ __('messages.accommodation') }}</a></li>
                    <li><a class=" scrollto" href="{{ route('website.event') }}">{{ __('messages.event') }}</a></li>
                    <li><a class=" scrollto"
                            href="{{ route('website.petawisata') }}">{{ __('messages.touristMap') }}</a>
                    </li>
                    <li><a class=" scrollto"
                        href="{{ route('kemitraan') }}">{{ __('messages.partner') }}</a>
                    </li>
                    @if (auth()->guard('wisatawans')->check())
    <li><a class="btn-sign" href="{{ route('wisatawan.home') }}"><i class="fa fa-sign-in"></i> Dashboard</a></li>
@else
    <li><a class="btn-sign" href="{{ route('wisatawan.login') }}"><i class="fa fa-sign-in"></i> {{ __('messages.login') }}</a></li>
@endif
                    <li class="language-dropdown">
                        <a class="scrollto" href="#bahasa">
                            {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }} &nbsp;<i class="fas fa-sort-down"></i>
                            <!-- Ikon drop-down dari Font Awesome -->
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('change_locale', ['locale' => 'id']) }}">Indonesia</a></li>
                            <li><a href="{{ route('change_locale', ['locale' => 'en']) }}">English</a></li>
                        </ul>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>

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
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container-lg mt-5">
                <h1><b>{{ __('messages.webTitle') }}</b></h1>

                <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up"
                    data-aos-delay="100">
                    <li data-filter=".filter-app">{{ __('messages.destination') }}</li>
                    <li data-filter=".filter-card">{{ __('messages.accommodation') }}</li>
                    <li data-filter=".filter-web">{{ __('messages.culinary') }} </li>
                </ul>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 col-md-12 portfolio-item filter-app">
                        <div class="row">
                            <div class="cardarticle-slider">
                                @foreach ($wisata as $item)
                                    <div class="cardarticle-wrapper">
                                        <article class="cardarticle">
                                            <a
                                                href="{{ route('website.webdetailwisata', $hash->encodeHex($item->id)) }}">
                                                <picture class="cardarticle__background">
                                                    @if ($item->media)
                                                        <img src="{{ $item->thumbnail }}" alt="Thumbnail">
                                                    @endif
                                                </picture>
                                            </a>

                                            <div class="cardarticle__category">
                                                {{ $item->namawisata }}
                                            </div>
                                            <div class="cardarticle__duration">
                                                <i class="ri-eye-fill"></i>{{ __('messages.webView') }}
                                                {{ $item->views }}
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ route('website.destinasi') }}"
                            class="portfolio btn-learn-more">{{ __('messages.webTours') }}</a>
                    </div>

                    <div class="col-lg-12 col-md-12 portfolio-item filter-web">
                        <div class="row">
                            <div class="cardkuliner-slider">
                                @foreach ($kuliner as $item)
                                    <div class="cardkuliner-wrapper">
                                        <kuliner class="cardkuliner">
                                            <a
                                                href="{{ route('website.webdetailkuliner', $hash->encodeHex($item->id)) }}">
                                                <picture class="cardkuliner__background">
                                                    @if ($item->media)
                                                        <img src="{{ $item->thumbnail }}" alt="Thumbnail">
                                                    @endif
                                                </picture>
                                            </a>

                                            <div class="cardkuliner__category">
                                                {{ $item->namakuliner }}
                                            </div>
                                            <div class="cardkuliner__duration">
                                                <i class="ri-eye-fill"></i>{{ __('messages.webView') }}
                                                {{ $item->views }}
                                            </div>
                                        </kuliner>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ route('website.kuliner') }}"
                            class="portfolio btn-learn-more">{{ __('messages.webCulinary') }}</a>
                    </div>
                    <div class="col-lg-12 col-md-12 portfolio-item filter-card">
                        <div class="row">
                            <div class="cardakomodasi-slider">
                                @foreach ($akomodasi as $item)
                                    <div class="cardakomodasi-wrapper">
                                        <akomodasi class="cardakomodasi">
                                            <a
                                                href="{{ route('website.webdetailakomodasi', $hash->encodeHex($item->id)) }}">
                                                <picture class="cardakomodasi__background">
                                                    @if ($item->media)
                                                        <img src="{{ $item->thumbnail }}" alt="Thumbnail">
                                                    @endif
                                                </picture>
                                            </a>

                                            <div class="cardakomodasi__category">
                                                {{ $item->namaakomodasi }}
                                            </div>
                                            <div class="cardakomodasi__duration">
                                                <i class="ri-eye-fill"></i>{{ __('messages.webView') }}
                                                {{ $item->views }}
                                            </div>
                                        </akomodasi>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ route('website.akomodasi') }}"
                            class="portfolio btn-learn-more">{{ __('messages.webAccommodations') }}</a>
                    </div>

                </div>
        </section>
     
        <!--=============== Calender Event ================ -->
        <div class="container-lg mt-5">
            <h1 class="mb-1">
                <b>{{ __('messages.Whatson') }}</b>
            </h1>
            <div class="text-lg fs-3">
                {{ __('messages.description') }}
                {{ __('messages.Findon') }}
            </div>

           
        </div>
        <!--=============== WND Calender Event ================ -->
        
        <div class="container">
            
            <div class="row justify-content-center">
                <main class="main col-md-8 px-2 py-3">
                    <div class="cardeven-slider">
                        @foreach ($event as $item)
                                <?php
                                $tanggalMulai = date('l, d F Y', strtotime($item->tanggalmulai));
                                $tanggalSelesai = date('l, d F Y', strtotime($item->tanggalselesai));
                                $tanggalMulai = strtr($tanggalMulai, __('messages'));
                                $tanggalSelesai = strtr($tanggalSelesai, __('messages'));
                                $tanggalMulai = mb_convert_case($tanggalMulai, MB_CASE_UPPER, 'UTF-8');
                                $tanggalSelesai = mb_convert_case($tanggalSelesai, MB_CASE_UPPER, 'UTF-8');
                                ?>
                                <div class="cardeven-wrapper">
                                    
                                        <div class="card mx-auto custom-card mb-5" id="prova">
                                            <!-- Card Header -->
                                            <div class="card-header d-flex justify-content-between align-items-center bg-white pl-3 pr-1 py-2">
                                                <div class="d-flex align-items-center">
                                                    <a href="" style="width: 32px; height: 32px; margin-right: 10px;">
                                                        <img src="https://kuninganbeu.kuningankab.go.id/images/logo/KuninganBeu.png" class="rounded-circle w-100">
                                                    </a>
                                                    <a href="" class="my-0 ml-2 text-dark text-decoration-none">
                                                        <strong>{{ $item->title }}</strong>
                                                    </a>
                                                    
                                                </div>
                                                <div class="card-dots">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-link text-muted" data-toggle="modal">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                    
                                                </div>
                                            </div>
                                            
                                            <!-- Card Image -->
                                                            <div class="even-slider swiper">
                                            
                                                                <div class="swiper-wrapper align-items-center">
                                                                    @foreach ($item->photos as $key => $media)
                                                                    <div class="swiper-slide">
                                                                        <a href="{{ route('website.webdetailevencalender', $hash->encodeHex($item->id)) }}">
                                                                        <img src="{{ $media->getUrl() }}" class="card-img" alt="post image" style="max-height: 767px" >
                                                                        </a>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="swiper-pagination"></div>
                                                            </div>
                                            {{-- <a href="{{ route('website.webdetailevencalender', $hash->encodeHex($item->id)) }}">
                                                
                                                <img class="card-img" src="{{ $item->thumbnail }}" alt="post image" style="max-height: 767px">
                                            </a> --}}
                                            <!-- Card Body -->
                                            <div class="card-body px-3 py-2">
                                                <div class="d-flex flex-row">
                                                            <button type="submit" class="btn pl-0">
                                                                <i class="fas fa-heart fa-2x" style="color:red"></i>
                                                            </button>

                                                            <a href="" class="btn pl-0">
                                                                <i class="far fa-comment fa-2x"></i>
                                                            </a>
                                                    
                                                        <!-- Share Button trigger modal -->
                                                        <button type="button" class="btn pl-0 pt-0">
                                                            <svg aria-label="Share Post" class="_8-yf5 " fill="#262626" height="22" viewBox="0 0 48 48" width="21"><path d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z"></path></svg>
                                                        </button>
                                                        
                    
                                                </div>  
                                                <div class="flex-row">
                                                    @php
                                                    $today = now()->format('Y-m-d');
                                                @endphp
                                                    <!-- Likes -->
                                                        <h6 class="card-title">
                                                            <strong> {{ $tanggalMulai }} - {{ $tanggalSelesai }} <br><br>
                                                                {{ $item->jammulai }} - {{ $item->jamselesai }}</strong>@if ($item->tanggalselesai <= $today && $item->tanggalselesai < $today)
                                                                <span style="background: rgb(241, 65, 108); color: rgb(255, 255, 255); border-radius: 10px;" class="px-3 py-1 ms-3 mb-2">
                                                                    {{ __('messages.eventEnd') }}
                                                                </span>
                                                            @else
                                                                <span style="background: rgb(65, 200, 241); color: rgb(255, 255, 255); border-radius: 10px;" class="px-3 py-1 ms-3 mb-2">
                                                                    {{ __('messages.eventStart') }}
                                                                </span>
                                                            @endif <a href="https://www.google.com/maps/dir/?api=1&destination={{ $item->latitude }},{{ $item->longitude }}" class="btn-even" style="border-radius: 15px;"onclick="arahkanSaya('{{ $item->latitude }}', '{{ $item->longitude }}')"><i class="uil uil-map-marker"></i>{{ __('messages.directMe') }}</button></a>
                                                        </h6>  {{-- <iframe style="height: 250px; width: 526PX; position: relative; overflow: hidden;"
                                                        src="https://maps.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}&output=embed"></iframe> --}}
                                                                        
                                
                    
                                                    {{-- Post Caption --}}
                                                    
                                                    <!-- Created At  -->
                                                    <p class="card-text text-muted">{{$item->created_at->diffForHumans()}}</p>
                                                </div>
                                            </div>
                    
                                            <!-- Card Footer -->
                                        
                                        </div>
                                </div>
                        @endforeach
                    </div>
                </main>
    
               
    
            </div>
        </div>
        <!-- ======= Promo Section ======= -->
        <section id="promo" class="align-items-center">
            <div class="home-slider owl-carousel">
                @foreach ($banerpromo as $banerpromo)
                    <div class="slider-item">
                        <img src="/upload/banerpromo/{{ $banerpromo->sampul }}"
                        style="width: 100%; height: auto; max-height: 258px;">
                    </div>
                @endforeach
            </div>
        </section><!-- End Promo -->


        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="row">
                    <div class="col-md-4">
                        <blockquote class="instagram-media" data-instgrm-captioned
                            data-instgrm-permalink="https://www.instagram.com/reel/C5i9Ad8B73T"
                            data-instgrm-version="14"
                            style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                            <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                    <div class="col-md-4">
                        <blockquote class="instagram-media" data-instgrm-captioned
                            data-instgrm-permalink="https://www.instagram.com/p/C6ai4DeynX8" data-instgrm-version="14"
                            style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                            <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                    <div class="col-md-4">
                        <blockquote class="instagram-media" data-instgrm-captioned
                            data-instgrm-permalink="https://www.instagram.com/p/C5HNifLSILx" data-instgrm-version="14"
                            style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                            <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                    

                </div>

            </div>






        </section>
        <!-- End Portfolio Section -->

        <div class="cardwisata-slider">
            @foreach ($wisatas as $item)
                <a href="{{ route('website.webdetailwisata', $hash->encodeHex($item->id)) }}">
                    <div class="cardwisata-wrapper">
                        <article class="cardwisata">
                            <picture class="cardwisata__background">
                                @if ($item->media)
                                    <img src="{{ $item->thumbnail }}" alt="Thumbnail" class="img-fluid">
                                @endif
                            </picture>
                            <div class="cardwisata__category">
                                {{ $item->namawisata }}
                            </div>
                            <div class="cardwisata__duration">
                                <i class="ri-eye-fill"></i>{{ __('messages.webView') }}
                                {{ $item->views }}
                            </div>
                        </article>
                    </div>
                </a>
            @endforeach
        </div>



        <!-- ======= Cuaca Section ======= -->
        <section id="cuaca" class="cuaca section-cuaca">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2 class="cuaca btn-learn-more">{{ __('messages.webWeather') }}</h2>
                        <div>
                        <h3 class="cuaca btn-learn-hove">Kabupaten Kuningan</h3>
                        </div>
                    <div class="tabcuaca">
                        <button class="active" onclick="fetchWeatherData('today')">{{ __('messages.webWeather1') }}</button>
                        <button onclick="fetchWeatherData('tomorrow')">{{ __('messages.webWeather2') }}</button>
                        <button onclick="fetchWeatherData('dayAfter')">{{ __('messages.webWeather3') }}</button>
                    </div>
                    
                        <div class="weather-containercuaca" id="cuaca-main"></div>
                </div>
               
            </div>
        </section><!-- End Cuaca Section -->


        <section id="portfolio" class="portfolio">
            <div class="container">
                <h2 class="portfolio btn-learn-more">{{ __('messages.supportby') }}</h2>
                <div class="row portfolio-container">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="cardsupportby-slider">
                                @foreach ($support as $support)
                                    <div class="cardsupportby-wrapper">
                                        <article class="cardsupportby">
                                            <img src="/upload/support/{{ $support->sampul }}"
                                                class="img-fluid blend-image" alt="">
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>
        </section>



   


        <!-- ======= Article Section ======= -->

        <!-- End Article Section -->

        <!-- ======= Our Instagram dengan Token --->
        <div class="container bg-splatter-x">


            <h3 class="igheader-title btn-learn-more">{{ __('messages.webInstagram') }}</h3>
            <div class="row mt-3">
                <div class="col-xl-12">
                    <div class="owl-carousel media owl-theme">
                        @foreach ($mediaData as $media)
                            <div class="col-lg-4">
                                <blockquote class="instagram-media" data-instgrm-captioned
                                    data-instgrm-permalink="{{ $media['permalink'] }}" data-instgrm-version="14"
                                    style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                                </blockquote>
                                <script async src="//www.instagram.com/embed.js"></script>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            {{-- 
            <div class="header-title my-5">
                <div class="bg-white rounded-1 border border-black d-inline-block text-center px-3 pt-2 mb-3"
                    style="box-shadow: 5px 5px 0px rgba(0, 0, 0, 1);">
                    <h3 class="fw-bold font-mono text-center">Our <span style="color:#FF269D;">Instagram FEED</span>
                    </h3>
                </div>
            </div> --}}


            {{-- <div class="row mt-3">
                <div class="col-xl-12">
                    <div class="owl-carousel media owl-theme">
                        @foreach ($mediaData as $media)
                        @if ($media['media_type'] == 'IMAGE')
                        <a href="{{ $media['permalink'] }}">
                                <div class="item">
                                    <div
                                        class="card shadow-card rounded-1 border border-black text-bg-light mb-3 mx-2 p-2">
                                        @if (isset($media['media_type']) && $media['media_type'] == 'IMAGE')
                                            <img src="{{ $media['thumbnail_url'] }}" class="card-img-top">
                                        @else
                                            <img src="{{ $media['media_url'] }}" class="card-img-top">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold font-mono text-start">
                                                {{ $media['username'] }}</h5>
                                            <div class="bisa scroll">
                                                <p class="card-text font-mono five-lines"
                                                    style="text-align: justify;">{!! nl2br($media['caption']) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div> --}}
        </div>




    </main><!-- End #main -->
    @include('layouts.website.container')
    @include('layouts.website.footer')

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <!-- Template Main JS File -->

    <script src="{{ asset('Frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('Frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('Frontend/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    {{-- <script src="{{ asset('Frontend/carosel/js/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('Frontend/carosel/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('Frontend/carosel/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web-animations/2.3.1/web-animations.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.3.1/smooth-scrollbar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script>
        

        function slider_carousel2Init() {
            $('.owl-carousel2.slider_carousel2').owlCarousel({
                dots: false,
                loop: true,
                margin: 30,
                stagePadding: 2,
                autoplay: true,
                nav: false,
                navText: ["<", ">"],
                autoplayTimeout: 1500,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 5
                    }
                }
            });
        }
      
        $('.media').owlCarousel({
            loop: true,
            margin: 10,
            animateOut: 'slideOutDown',
            animateIn: 'flipInX',
            autoplay: true,
            dots: false,
            autoplayTimeout: 7000,
            autoplayHoverPause: false,
            nav: true,
            navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
        jQuery('.cardeven-slider').slick({
            slidesToShow: 1,
            autoplay: true,
            loop: true,
            slidesToScroll: 1,
            autoplayHoverPause: true,
            dots: true,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                        
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        jQuery('.cardarticle-slider').slick({
            slidesToShow: 3,
            autoplay: true,
            loop: true,
            slidesToScroll: 1,
            autoplayHoverPause: true,
            dots: false,
            prevArrow: false,
            nextArrow: false,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        jQuery('.cardsupportby-slider').slick({
            slidesToShow: 5,
            autoplay: true,
            loop: true,
            slidesToScroll: 1,
            autoplayHoverPause: true,
            dots: false,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        jQuery('.cardkuliner-slider').slick({
    slidesToShow: 3,
    autoplay: true,
    loop: true,
    slidesToScroll: 1,
    autoplayHoverPause: true,
    dots: false,
    prevArrow: false,
    nextArrow: false,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1
            }
        }
    ]
});

        jQuery('.cardakomodasi-slider').slick({
            slidesToShow: 3,
            autoplay: true,
            loop: true,
            slidesToScroll: 1,
            autoplayHoverPause: true,
            dots: false,
            prevArrow: false,
            nextArrow: false,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        const fetchWeatherData = async (day) => {
    try {
        const response = await fetch('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm1=32');
        const data = await response.json();
        const kuninganData = data.data[7]; // Ambil data cuaca untuk Kuningan

        // Pilih data berdasarkan hari
        let selectedData;
        if (day === 'today') {
            selectedData = kuninganData.cuaca[0];
        } else if (day === 'tomorrow') {
            selectedData = kuninganData.cuaca[1];
        } else if (day === 'dayAfter') {
            selectedData = kuninganData.cuaca[2];
        }

        const weatherContainer = document.getElementById('cuaca-main');
        weatherContainer.innerHTML = ''; // Menghapus konten sebelumnya

        selectedData.forEach(weather => {
            const date = weather.local_datetime;
            const temperature = weather.hu;
            const weatherDesc = weather.weather_desc;
            const icon = weather.image;

            const weatherCard = `
                <div class="weather-cardcuaca">
                    <div class="timecuaca">${date} WIB</div>
                    <img src="${icon}" alt="Icon cuaca" />
                    <div class="temperature">${temperature}°C</div>
                    <div class="descriptioncuaca">${weatherDesc}</div>
                </div>
            `;
            weatherContainer.innerHTML += weatherCard;
        });

        // Update tabcuaca aktif
        document.querySelectorAll('.tabcuaca button').forEach(button => {
            button.classList.remove('active');
        });
        document.querySelector(`.tabcuaca button[onclick="fetchWeatherData('${day}')"]`).classList.add('active');

    } catch (error) {
        console.error("Error fetching weather data:", error);
        document.getElementById('cuaca-main').innerHTML = error.message;
    }
};

// Mengambil data cuaca pertama kali saat halaman dimuat
fetchWeatherData('today');


     

        jQuery('.cardwisata-slider').slick({
            slidesToShow: 5,
            loop: true,
            autoplay: true,
            slidesToScroll: 1,
            dots: false,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        let cardwisatas = document.querySelectorAll('.cardwisata');
        let cardwisata;
        let modalcard = document.querySelector('.modalcard');
        let closeButton = document.querySelector('.modalcard__close-button');
        let page = document.querySelector('.page');
        const cardwisataBorderRadius = 20;
        const openingDuration = 600; //ms
        const closingDuration = 600; //ms
        const timingFunction = 'cubic-bezier(.76,.01,.65,1.38)';

        var Scrollbar = window.Scrollbar;
        Scrollbar.init(document.querySelector('.modalcard__scroll-area'));


        function flipAnimation(first, last, options) {
            let firstRect = first.getBoundingClientRect();
            let lastRect = last.getBoundingClientRect();

            let deltas = {
                top: firstRect.top - lastRect.top,
                left: firstRect.left - lastRect.left,
                width: firstRect.width / lastRect.width,
                height: firstRect.height / lastRect.height
            };

            return last.animate([{
                transformOrigin: 'top left',
                borderRadius: `
    ${cardwisataBorderRadius/deltas.width}px / ${cardwisataBorderRadius/deltas.height}px`,
                transform: `
      translate(${deltas.left}px, ${deltas.top}px) 
      scale(${deltas.width}, ${deltas.height})
    `
            }, {
                transformOrigin: 'top left',
                transform: 'none',
                borderRadius: `${cardwisataBorderRadius}px`
            }], options);
        }

        cardwisatas.forEach((item) => {
            item.addEventListener('click', (e) => {
                jQuery('.cardwisata-slider').slick('slickPause');
                cardwisata = e.currentTarget;
                page.dataset.modalcardState = 'opening';
                cardwisata.classList.add('cardwisata--opened');
                cardwisata.style.opacity = 0;
                document.querySelector('body').classList.add('no-scroll');

                let animation = flipAnimation(cardwisata, modalcard, {
                    duration: openingDuration,
                    easing: timingFunction,
                    fill: 'both'
                });

                animation.onfinish = () => {
                    page.dataset.modalcardState = 'open';
                    animation.cancel();
                };
            });
        });

        closeButton.addEventListener('click', (e) => {
            page.dataset.modalcardState = 'closing';
            document.querySelector('body').classList.remove('no-scroll');

            let animation = flipAnimation(cardwisata, modalcard, {
                duration: closingDuration,
                easing: timingFunction,
                direction: 'reverse',
                fill: 'both'
            });

            animation.onfinish = () => {
                page.dataset.modalcardState = 'closed';
                cardwisata.style.opacity = 1;
                cardwisata.classList.remove('cardwisata--opened');
                jQuery('.cardwisata-slider').slick('slickPlay');
                animation.cancel();
            };
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendPositionToServer, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
        
        function sendPositionToServer(position) {
            fetch('/log-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                })
            }).then(response => {
                if (response.ok) {
                    console.log("Location logged successfully");
                } else {
                    console.log("Failed to log location");
                }
            }).catch(error => {
                console.log("Error logging location:", error);
            });
        }
        
        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("Terimakasih.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
        </script>
        
  
</body>

</html>
