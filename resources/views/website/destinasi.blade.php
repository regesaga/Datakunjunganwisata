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
    </section><!-- End Hero -->

    <main id="main">
        <!-- ======= Wisata Section ======= -->
        <section id="content">
            <div class="container">
                <div class="card mb-5 shadow">
                    <div class="card-body">

                        <form action="{{ route('website.destinasi') }}" method="get">
                            <section class="ftco-section services-section" style="margin-top:2rem; margin-bottom:2rem;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12 mt-4">
                                            <h5 class="mb-0">{{ __('messages.destinasi1') }}</h5>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-3 col-sm-4">
                                                    <hr
                                                        style="height: 2px;
                                    background-color: #0F304F;
                                    border: none;">
                                                </div>
                                                <div class="col-lg-6"></div>
                                            </div>
                                            <div class="input-group w-100 mt-1">
                                                <div class="input-group mb-3">
                                                    <input type="search" class="form-control" id="cari" value=""
                                                        name="keyword" placeholder="{{ __('messages.destinasi1') }}..">
                                                    <button class="btn btn-secondary" type="submit"
                                                        id="button-addon2">{{ __('messages.search') }}</button>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-sm-12 mt-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="mb-0">{{ __('messages.category') }}</h5>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <hr
                                                                style="height: 2px;
                                            background-color: #0F304F;
                                            border: none;">
                                                            <div class="col-lg-6"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="float-end mt-2">
                                                        <button class="btn btn-sm text-white text-sm"
                                                            style="background-color: #0F304F;"
                                                            onchange="submit()">{{ __('messages.search') }}
                                                            {{ __('messages.category') }}</button>
                                                        {{-- <a href=""
                                            class="btn btn-sm text-white text-sm" style="background-color: #0F304F;">
                                            Cari Kategori</a> --}}
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
                                                @foreach ($cateegoryWisata as $item)
                                                    <div class="col">
                                                        <div class="">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input"
                                                                    id="cat-list-{{ $item->id }}" type="checkbox"
                                                                    name="cat_list[]" value="{{ $item->id }}"
                                                                    @if (request()->filled('cat_list') && in_array($item->id, request()->query('cat_list'))) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="cat-list-{{ $item->id }}">
                                                                    {{ $item->category_name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>

                        <div class="row g-4 mb-5" id="publishContainer">
                            @foreach ($wisatas as $item)
                                <?php
                                date_default_timezone_set('Asia/Jakarta');
                                $waktuSaatIni = now();
                                
                                // Konversi waktu buka dan waktu tutup dari string ke objek Carbon untuk memudahkan perbandingan
                                $jamBuka = \Carbon\Carbon::createFromTimeString($item->jambuka);
                                $jamTutup = \Carbon\Carbon::createFromTimeString($item->jamtutup);
                                // dd($jamTutup);
                                ?>

                                <article class="entry event col-md-6 col-lg-4 mb-0 d-flex align-items-stretch">
                                    <div
                                        class="grid-inner bg-white row g-0 p-2 border-1 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
                                        <div class="col-12 mb-md-0">
                                            <div class="entry-image mb-2">
                                                <a
                                                    href="{{ route('website.webdetailwisata', $hash->encodeHex($item->id)) }}">
                                                    <img src="{{ $item->thumbnail }}" class="rounded-5" loading="lazy"
                                                        height= "300px">
                                                    <div class="bg-overlay">
                                                        <div
                                                            class="bg-overlay-content justify-content-start align-items-start">
                                                            <div class="badge badge-pill badge-orange">
                                                                {{ $item->getCategory->category_name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12 p-4 pt-0 pb-1">
                                            <div class="entry-title nott">
                                                <h4>
                                                    {{ $item->namawisata }}
                                                </h4>
                                                <p style=color:#000;>{{ $item->kecamatan->Kecamatan }}</p>
                                            </div>

                                            
                                            <div class="entry-meta no-separator mb-3">
                                                
                                                <ul>
                                                    <li class="fw-normal">
                                                        <p style=color:#000;>{{ $item->jambuka }} S.d {{ $item->jamtutup }}</p>
                                                    </li>
                                                    <li class="fw-normal ">
                                                        @if ($waktuSaatIni->between($jamBuka, $jamTutup))
                                                            <span class="badge badge-pill badge-hijau">
                                                                {{ __('messages.open') }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-pill badge-merah">
                                                                {{ __('messages.close') }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                   
                                                    
                                                    
                                                </ul>
                                            </div>
                                            <div class="entry-meta no-separator mb-3">
                                                <ul>
                                                    <li class="fw-normal">
                                                        <i class="ri-eye-fill"></i>{{ __('messages.webView') }}
                                                        {{ $item->views }}
                                                    </li>
                                                    <li>
                                                        <button class="btn-outline-toska">
                                                        <a
                                                            href="{{ route('website.webdetailwisata', $hash->encodeHex($item->id)) }}">{{ __('messages.viewDetail') }}</a></button>
                                                    </li>
                                                </ul>
                                            </div>


                                           
                                        </div>
                                    </div>
                                </article>
                            @endforeach

                            <nav>
                                <ul class="pagination pagination-rounded pagination-3d pagination-md">
                                    {{ $wisatas->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container-lg mt-5">
            <h1 class="mb-1">
                <b>{{ __('messages.paketwisata') }}</b>
            </h1>
            <div class="text-lg fs-3">
                {{ __('messages.Findon') }}
            </div>

           
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <main class="main col-md-8 px-2 py-3">
                    <div class="cardeven-slider">
                        @foreach ($paketwisata as $item)
                                    <div class="cardeven-wrapper">
                                        <div class="card mx-auto custom-card mb-5" id="prova">
                                            <!-- Card Header -->
                                            <div class="card-header d-flex justify-content-between align-items-center bg-white pl-3 pr-1 py-2">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('website.webdetailpaketwisata', $hash->encodeHex($item->id)) }}" style="width: 32px; height: 32px; margin-right: 10px;">
                                                        <img src="https://kuninganbeu.kuningankab.go.id/images/logo/KuninganBeu.png" class="rounded-circle w-100">
                                                    </a>
                                                    <a href="{{ route('website.webdetailpaketwisata', $hash->encodeHex($item->id)) }}" class="my-0 ml-2 text-dark text-decoration-none">
                                                        <strong>{{ __('messages.paketwisata') }}</strong>
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
                                                                        <a href="{{ route('website.webdetailpaketwisata', $hash->encodeHex($item->id)) }}" class="my-0 ml-2 text-dark text-decoration-none">
                                                                        <img src="{{ $media->getUrl() }}" class="card-img" alt="post image" style="max-height: 767px" >
                                                                        </a>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="swiper-pagination"></div>
                                                            </div>
                                           
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
                                                            
                                                                <!-- Likes -->
                                                                <a href="{{ route('website.webdetailpaketwisata', $hash->encodeHex($item->id)) }}" class="my-0 ml-2 text-dark text-decoration-none">
                                                                <strong>{{ $item->namapaketwisata }}</strong></a>
                                                                    <h6 class="card-title">
                                                                        <strong> 
                                                                            @foreach ($item->htpaketwisata as $ticketCategory)
                                                                            <div class="badge bg-light text-dark rounded-pill">{{ $ticketCategory->jenis }} Rp. {{ number_format($ticketCategory->harga, 0, ".", ".") }},-</div>
                                                                            @endforeach</strong>
                                                                    </h6>
                                                                    <h5>
                                                                        <a  href="https://wa.me/{{ preg_replace('/^0/', '62', $item->telpon) }}" class="btn btn-outline-hijau text-white text-center w-100 fs-15px mt-3" style="border-radius: 15px; padding: 15px;"><svg  width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path  fill-rule="evenodd" clip-rule="evenodd" d="M13.7192 25.2333C7.51599 25.2333 2.4873 20.2046 2.4873 14.0014C2.4873 7.79822 7.51599 2.76953 13.7192 2.76953C19.9224 2.76953 24.9511 7.79822 24.9511 14.0014C24.9511 20.2046 19.9224 25.2333 13.7192 25.2333ZM13.2856 15.3639C12.7856 15.8638 12.0218 15.9878 11.3894 15.6716C10.757 15.3554 9.99325 15.4793 9.4933 15.9793L7.79615 17.6764C7.7345 17.7381 7.68805 17.8132 7.66048 17.8959C7.5624 18.1902 7.72142 18.5082 8.01566 18.6063L9.53626 19.1132C10.9965 19.5999 12.6064 19.2199 13.6948 18.1315L18.1867 13.6396C19.1866 12.6397 19.4345 11.1121 18.8021 9.84734L18.0916 8.42635C18.0646 8.37236 18.0291 8.32308 17.9864 8.2804C17.7671 8.06108 17.4115 8.06108 17.1922 8.2804L15.4035 10.0691C14.9035 10.5691 14.7796 11.3329 15.0958 11.9652C15.412 12.5976 15.288 13.3614 14.7881 13.8614L13.2856 15.3639Z" fill="white"></path></svg> &ensp;{{$item->telpon}}</a></div>
                                                                    </h5>
                                                                <!-- Created At  -->
                                                                <p class="card-text text-muted">{{$item->created_at->diffForHumans()}}</p>
                                                            </div>
                                                        </div>
                                    </div>
                        @endforeach
                    </div>
                </main>
            </div>
        </div>
    </main>
    @include('layouts.website.container')
    @include('layouts.website.footer')

    @push('javascript-bottom')
    <script>
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
        </script>
        <script>
            function redirectToCategory() {
                var selectedCategory = document.getElementById("categorySelect").value;
                if (selectedCategory !== "") {
                    window.location.href = "{{ route('website.kuliner') }}?category=" + selectedCategory;
                }
            }
        </script>
    @endpush
@endsection
