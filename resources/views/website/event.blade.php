@extends('layouts.website.main')

@section('content')
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

    <div class="container-lg mt-5">
        <h1 class="mb-1">
            <b>{{ __('messages.title') }}</b>
        </h1>
        <div class="text-lg fs-3">
            {{ __('messages.description') }}
        </div>
        <div class="card my-5 shadow">
            <div class="card-body">
                <form action="{{ route('website.event') }}" method="get" class="row  align-items-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="form-label fw-bold fs-4">{{ __('messages.sort') }}</label>
                            <select class="form-select" name="order" id="exampleFormControlSelect1" onchange="submit()">
                                <option value="0" hidden>
                                    {{ __('messages.select') }} {{ __('messages.category') }}</option>
                                <option value="1">
                                    {{ __('messages.event1') }}
                                </option>
                                <option value="2">
                                    {{ __('messages.event2') }}
                                </option>
                                <option value="3">
                                    {{ __('messages.event3') }} (A - Z)
                                </option>
                                <option value="4">
                                    {{ __('messages.event3') }} (Z - A)
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="cari" class="form-label fw-bold fs-4">{{ __('messages.search') }}</label>
                            <div class="input-group mb-3">
                                <input type="search" class="form-control" id="cari" value="" name="keyword"
                                    placeholder="{{ __('messages.search') }} event..">
                                <button class="btn btn-secondary" type="submit" id="button-addon2">{{ __('messages.search') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="row my-5">
            @foreach ($event as $item)
                <?php
                $tanggalMulai = date('l, d F Y', strtotime($item->tanggalmulai));
                $tanggalSelesai = date('l, d F Y', strtotime($item->tanggalselesai));
                $tanggalMulai = strtr($tanggalMulai, __('messages'));
                $tanggalSelesai = strtr($tanggalSelesai, __('messages'));
                $tanggalMulai = mb_convert_case($tanggalMulai, MB_CASE_UPPER, 'UTF-8');
                $tanggalSelesai = mb_convert_case($tanggalSelesai, MB_CASE_UPPER, 'UTF-8');
                ?>
                <article class="entry event col-lg-6 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                    <div class="grid-inner bg-white row g-0 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
                        <div class="col-md-4 mb-md-0 w-100">
                            <a class="entry-image mb-0 h-100" href="{{ route('website.webdetailevencalender', $hash->encodeHex($item->id)) }}">
                                @if ($item->media)
                                <img src="{{ $item->thumbnail }}" alt="Inventore voluptates velit totam ipsa tenetur"
                                class="rounded-2" loading="lazy" height= "420px">
                                                    @endif
                                
                            </a>
                        </div>
                        
                        <div class="col-md-12 p-4">
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
                            
                            @if ($item->tanggalselesai <= $today && $item->tanggalselesai < $today)
                                <span style="background: rgb(241, 65, 108); color: rgb(255, 255, 255); border-radius: 10px;" class="px-3 py-1 ms-3 mb-2">
                                    {{ __('messages.eventEnd') }}
                                </span>
                            @else
                                <span style="background: rgb(65, 200, 241); color: rgb(255, 255, 255); border-radius: 10px;" class="px-3 py-1 ms-3 mb-2">
                                    {{ __('messages.eventStart') }}
                                </span>
                            @endif
                            </div>
                            <div class="entry-title nott">
                                <h3>{{ $item->title }}</h3>
                            </div>
                            
                           
                        </div>
                    </div>
                </article>
            @endforeach
            <nav>
                <ul class="pagination pagination-rounded pagination-3d pagination-md">
                    {{ $event->links() }}
                </ul>
            </nav>

        </div> --}}

    </div>
    <div class="container">
            
        <div class="row justify-content-center">
            <main class="main col-md-8 px-2 py-3">
                @foreach ($event as $item)
                <?php
                $tanggalMulai = date('l, d F Y', strtotime($item->tanggalmulai));
                $tanggalSelesai = date('l, d F Y', strtotime($item->tanggalselesai));
                $tanggalMulai = strtr($tanggalMulai, __('messages'));
                $tanggalSelesai = strtr($tanggalSelesai, __('messages'));
                $tanggalMulai = mb_convert_case($tanggalMulai, MB_CASE_UPPER, 'UTF-8');
                $tanggalSelesai = mb_convert_case($tanggalSelesai, MB_CASE_UPPER, 'UTF-8');
                ?>
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
                    @endforeach
                    <nav>
                        <ul class="pagination pagination-rounded pagination-3d pagination-md">
                            {{ $event->links() }}
                        </ul>
                    </nav>
            </main>

           

        </div>
    </div>
    @include('layouts.website.container')
    @include('layouts.website.footer')
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

   
@endsection
