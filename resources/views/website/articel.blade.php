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
    <main id="main">
        <div class="container-lg mt-5">
            <h1 class="mb-1">
                <b>{{ __('messages.articel') }}</b>
            </h1>
            
        
            <div class="row my-5">
                @foreach ($articel as $item)
                    <article class="entry event col-lg-6 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                        <div class="grid-inner bg-white row g-0 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
                            <div class="col-md-4 mb-md-0 w-100">
                                <a href="{{ route('website.webdetailarticel', $hash->encodeHex($item->id)) }}"
                                    class="entry-image mb-0 h-100">
                                    <img src="/upload/article/{{ $item->sampul }}"
                                        alt="Inventore voluptates velit totam ipsa tenetur" class="rounded-2" loading="lazy" height= "420px">
                                </a>
                            </div>
                            <div class="col-md-12 p-4">
                                
                                <div class="entry-title nott">
                                    <h3>{{ $item->judul }}</h3>
                                </div>
                                <small class="card-text">
                            
                                    @foreach ($item->tag as $row)
                                        @if ($loop->last)
                                            <span class="badge badge-pill badge-toska">{{$row->nama}}</span>
                                        @else
                                            <span class="badge badge-pill badge-toska">{{$row->nama}}</span>
                                        @endif
                                    @endforeach- <span class="text-muted">{{$item->created_at->diffForHumans()}}</span>
                                    
                                
                                </small>
                                <br>
                        
                                <small>{{ __('messages.author') }} <span class="badge badge-pill badge-orange">{{$item->user->name}}</span></small> <i class="ri-eye-fill"></i> {{ __('messages.webView') }}  {{$item->views}}
                                <hr>
                                
                            </div>
                        </div>
                    </article>
                @endforeach
                <nav>
                    <ul class="pagination pagination-rounded pagination-3d pagination-md">
                        {{ $articel->links() }}
                    </ul>
                </nav>

            </div>

        </div>
        
    </main>
    @include('layouts.website.container')
    @include('layouts.website.footer')
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


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
