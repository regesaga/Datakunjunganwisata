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
                    <li>{{ __('messages.articel') }}</li>
                </ol>
            </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Wisata Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-7">
                          
                                                    <img src="/upload/article/{{$article->sampul}}" width="800" height="550">
                                                    
                                                    <small class="card-text">
                                                
                                                        @foreach ($article->tag as $row)
                                                            @if ($loop->last)
                                                                <span class="badge badge-pill badge-toska">{{$row->nama}}</span>
                                                            @else
                                                                <span class="badge badge-pill badge-toska">{{$row->nama}}</span>
                                                            @endif
                                                        @endforeach- <span class="text-muted">{{$article->created_at->diffForHumans()}}</span>
                                                        
                                                       
                                                    </small>
                                                    <small> <span class="badge badge-pill badge-orange">{{ __('messages.author') }} {{$article->user->name}}</span></small> <i class="ri-eye-fill"></i> {{ __('messages.webView') }}  {{$article->views}}

                                                    <br>
                                                    <hr>
                                            
                                                    <h1 >{{$article->judul}}</h1>
                                                    <p class="card-text">{!!$article->konten!!}</p>

                    </div>
                    <div class="col-lg-5">
                        <div class="portfolio-info">
                            <h3>{{ __('messages.articelother') }}</h3><span class="text-muted mr-2">
                            </span>
                            <div data-v-c78794cc="" style="background-color: rgb(243, 246, 249);"
                                class="p-3 rounded-patern mt-3">
                                <div data-v-c78794cc="" class="bg-white rounded-patern p-3">
                                    <div data-v-c78794cc="" class="row">
                                        @foreach ($articel as $item)
                                        <div data-v-c78794cc="" class="col-lg-4 fs-14px my-2"> 
                                            <a href="{{ route('website.webdetailarticel', $hash->encodeHex($item->id)) }}">
                                                <img src="/upload/article/{{ $item->sampul }}" class="article-image"  loading="lazy">
                                            </a>
                                        </div>
                                        
                                        <div data-v-c78794cc="" class="col-lg-8 fs-14px my-2" style="font-weight: 500;">
                                            <h3>{{ $item->judul }}</h3>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                                
                            </div>

                         
                            

                           

                        </div>

                       

                    </div>

                            </div>
                            <div id="disqus_thread" class="mt-4"></div>

            </div>
            <script>
                /**
                 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                /*
                var disqus_config = function () {
                this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
                */
                (function() { // DON'T EDIT BELOW THIS LINE
                    var d = document,
                        s = d.createElement('script');
                    s.src = 'https://blog-wwe7ssfgas.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
                    Disqus.</a></noscript>
        </section><!-- End Portfolio Details Section -->

    </main>
    

    <!-- ======= Footer ======= -->
    @include('layouts.website.footer')

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
@endsection
