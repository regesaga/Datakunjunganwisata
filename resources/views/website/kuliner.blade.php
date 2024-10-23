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

                        <form action="{{ route('website.kuliner') }}" method="get" class="row  align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label fw-bold fs-4">{{ __('messages.category') }}</label>
                                    <select name="category" id="categorySelect" class="form-select"
                                        onchange="redirectToCategory()">
                                        <option value="">{{ __('messages.all') }}</option>
                                        @foreach ($categoryKuliner as $item)
                                            <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="cari"
                                        class="form-label fw-bold fs-4">{{ __('messages.search') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="search" class="form-control" id="cari" value=""
                                            name="keyword" placeholder="cari kuliner atau cafe &amp; resto disini..">
                                        <button class="btn btn-secondary" type="submit"
                                            id="button-addon2">{{ __('messages.search') }}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="row g-4 mb-5" id="publishContainer">
                    @foreach ($kuliner as $item)
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
                                        <a href="{{ route('website.webdetailkuliner', $hash->encodeHex($item->id)) }}">
                                            <img src="{{ $item->thumbnail }}" class="rounded-5" loading="lazy"
                                                height= "300px">
                                            <div class="bg-overlay">
                                                <div class="bg-overlay-content justify-content-start align-items-start">
                                                    <div class="badge badge-pill badge-kuning">
                                                        {{ $item->getCategory->category_name }}
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-12 p-4 pt-0 pb-1">
                                    <div class="entry-title nott">
                                        <h4>
                                            {{ $item->namakuliner }}
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
                                                    href="{{ route('website.webdetailkuliner', $hash->encodeHex($item->id)) }}">{{ __('messages.viewDetail') }}</a></button>
                                            </li>
                                        </ul>
                                    </div>


                                   
                                </div>
                            </div>
                        </article>
                    @endforeach

                    <nav>
                        <ul class="pagination pagination-rounded pagination-3d pagination-md">
                            {{ $kuliner->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </main><!-- End #main -->


    <div id="preloader"></div>
    @include('layouts.website.container')
    @include('layouts.website.footer')
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
