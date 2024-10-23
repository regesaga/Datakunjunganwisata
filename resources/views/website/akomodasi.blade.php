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
        <section>

            <!-- Google tag (gtag.js) -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-26YC4R3P36"></script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());

                gtag('config', 'G-26YC4R3P36');
            </script>
        <form action="{{ route('website.akomodasi') }}" method="get">
            <section class="ftco-section services-section" style="margin-top:2rem; margin-bottom:2rem;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 mt-4">
                            <h5 class="mb-0">{{ __('messages.search') }} {{ __('messages.accommodation') }}</h5>
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
                                    <input type="search" class="form-control" id="cari" value="" name="keyword"
                                        placeholder="{{ __('messages.search') }} {{ __('messages.accommodation') }}..">
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
                                        <button class="btn btn-sm text-white text-sm" style="background-color: #0F304F;"
                                            onchange="submit()">{{ __('messages.search') }} {{ __('messages.category') }}</button>
                                        {{-- <a href=""
                                            class="btn btn-sm text-white text-sm" style="background-color: #0F304F;">
                                            Cari Kategori</a> --}}
                                    </div>
                                </div>
                            </div>



                            <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
                                @foreach ($category_akomondasi as $item)
                                    <div class="col">
                                        <div class="">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="cat-list-{{ $item->id }}"
                                                    type="checkbox" name="cat_list[]" value="{{ $item->id }}"
                                                    @if (request()->filled('cat_list') && in_array($item->id, request()->query('cat_list'))) checked @endif>
                                                <label class="form-check-label" for="cat-list-{{ $item->id }}">
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

            <div class="container-lg mt-5">
                {{-- <form action="{{ route('website.akomodasi') }}" method="get">
                    <div class="row">
                        <div class="card my-5 shadow border-0">
                            <div class="card-body">
                                <div class="input-group">
                                    <input type="search" class="form-control" value="" name="keyword" id="cari"
                                        placeholder="Ketik nama daerah, nama hotel, atau landmark">
                                    <button class="btn btn-light" type="submit" id="button-addon2">
                                        <i class="bi-search fs-3"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> --}}

                <div class="row">

                    <div class="col-md-12 mb-3 mb-sm-0">
                        @foreach ($akomodasi as $item)
                            <?php
                            date_default_timezone_set('Asia/Jakarta');
                            $waktuSaatIni = now();
                            
                            // Konversi waktu buka dan waktu tutup dari string ke objek Carbon untuk memudahkan perbandingan
                            $jamBuka = \Carbon\Carbon::createFromTimeString($item->jambuka);
                            $jamTutup = \Carbon\Carbon::createFromTimeString($item->jamtutup);
                            // dd($jamTutup);
                            ?>

                            <div class="card shadow h-shadow-sm h-shadow all-ts h-translate-y-sm mb-5 overflow-hidden"
                                style="border-radius: 40px">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        <img src={{ $item->thumbnail }} class="img-fluid w-100 h-100" alt="..."
                                            loading="lazy">
                                    </div>
                                    <div class="col-md-7 ps-3 pe-1">
                                        <h4 class="card-title fs-3">
                                            <br>
                                            <a href={{ route('website.webdetailakomodasi', $hash->encodeHex($item->id)) }}
                                                class="link-underline-opacity-0 link-info text-dark mt-4">
                                                {{ $item->namaakomodasi }}
                                            </a>
                                            <br>
                                            <div class="rating-container theme-krajee-svg rating-sm rating-animate">
                                                <small class="p-2 rounded text-white me-2 my-2"
                                                    style="background-color: #0F304F">
                                                    {{ $item->getCategoryAkomodasi->category_name }}
                                                </small>
                                            </div>
                                            <div class="text-lg fw-normal fs-5 mt-3">
                                                <i class="uil fs-3 text-warning uil-map-marker"></i>
                                                {{ $item->alamat }}

                                            </div>
                                        </h4>
                                        <div class="text-lg fw-normal fs-5 mt-3">
                                            {{ $item->jambuka }} S.d {{ $item->jamtutup }}
                                            @if ($waktuSaatIni->between($jamBuka, $jamTutup))
                                                <span class="badge bg-success px-3 py-2">
                                                    {{ __('messages.open') }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">
                                                    {{ __('messages.close') }}
                                                </span>
                                            @endif
                                        </div>

                                        <button class="btn my-1 btn-primary"
                                            onclick="arahkanSaya('{{ $item->latitude }}', '{{ $item->longitude }}')">
                                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $item->latitude }},{{ $item->longitude }}"
                                                class="fw-normal text-white">
                                                {{ __('messages.directMe') }}
                                            </a></button>

                                        <button class="btn my-1 btn-warning">
                                            <a href="{{ route('website.webdetailakomodasi', $hash->encodeHex($item->id)) }}"
                                                class="fw-normal text-white">{{ __('messages.viewDetail') }}</a>
                                        </button>

                                        <i class="ri-eye-fill"></i>{{ __('messages.webView') }}
                                        {{ $item->views }}

                                        <div class="row mt-2 justify-content-between my-3">
                                            <div class="col-md-12">
                                                {{-- <div class="entry-meta no-separator mb-3">
                                                    <ul>
                                                        <li><a href="https://www.instagram.com/grandtryashotel/"
                                                                class="fw-normal text-dark"><i
                                                                    class="uil bi-instagram fs-1"></i>
                                                            </a></li>
                                                    </ul>
                                                </div> --}}
                                                {{-- <p class="card-text mb-3">
                                                    <font>
                                                        Mulai Dari
                                                    </font>
                                                    <strong class="fs-4 text-danger">
                                                        <br>{{ $item->hargatiket[0]->harga }} - 
                                                    </strong>
                                                </p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <nav>
                            <ul class="pagination pagination-rounded pagination-3d pagination-md">
                                {{ $akomodasi->links() }}

                                {{-- <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link"
                                            href="https://www.visitcirebon.id/akomodasi?page=2">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link"
                                            href="https://www.visitcirebon.id/akomodasi?page=3">3</a>
                                    </li>
                                    <li class="page-item"><a class="page-link"
                                            href="https://www.visitcirebon.id/akomodasi?page=4">4</a>
                                    </li>
                                    <li class="page-item"><a class="page-link"
                                            href="https://www.visitcirebon.id/akomodasi?page=2" aria-label="Next"><span
                                                aria-hidden="true">»</span></a>
                                    </li> --}}

                            </ul>
                        </nav>

                    </div>

                </div>
            </div>
            <div class="clearfix mb-5"></div>
        </section>
    </main><!-- End #main -->
    @include('layouts.website.container')
    @include('layouts.website.footer')

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web-animations/2.3.1/web-animations.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.3.1/smooth-scrollbar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

    @push('javascript-bottom')
        <script>
            function redirectToCategory() {
                var selectedCategory = document.getElementById("categorySelect").value;
                if (selectedCategory !== "") {
                    window.location.href = "{{ route('website.kuliner') }}?category=" + selectedCategory;
                }
            }
        </script>
        @include('java_script.kuliner.script')
    @endpush
@endsection
