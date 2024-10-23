@extends('layouts.website.main')

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="home-slider owl-carousel js-fullheight">
            @foreach ($wisata->photos as $key => $media)
                <div class="slider-item js-fullheight" style="background-image:url('{{ $media->getUrl() }}');">
                    <div class="container">
                        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                            <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" class="img-fluid animated"
                                style="max-height: 200px; width: auto;">
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
                    <li>Wisata Details</li>
                </ol>
               
            </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Wisata Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-7">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">
                                @foreach ($wisata->photos as $key => $media)
                                    <div class="swiper-slide">
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl() }}" alt="Foto">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <h3>{{ $wisata->namawisata }}</h3>

                        <div class="portfolio-description">
                            <p>
                                {!! $wisata->deskripsi !!}
                            </p>
                        </div>
                    </div>


                    <div class="col-lg-5">
                        <span class="fas fa-eye mr-1"></span>
                            {{ __('messages.webView') }} {{ $wisata->views }}
                            
                            
                            <div class="card card-primary">
                                <div class="card-header">
                                  <h3 class="card-title">wisata information</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                 
                  
                                  <strong><i class="fas fa-map-marker-alt mr-1"></i> {{ __('messages.address') }}</strong>
                  
                                  <p class="text-muted">{{ $wisata->alamat }}</p>
                  
                                  <hr>
                  
                                  <strong><i class="fas fa-clock mr-1"></i> {{ __('messages.operational') }}  <?php
                                    date_default_timezone_set('Asia/Jakarta');
                                    $waktuSaatIni = now();
                                    
                                    // Konversi waktu buka dan waktu tutup dari string ke objek Carbon untuk memudahkan perbandingan
                                    $jamBuka = \Carbon\Carbon::createFromTimeString($wisata->jambuka);
                                    $jamTutup = \Carbon\Carbon::createFromTimeString($wisata->jamtutup);
                                    // dd($jamTutup);
                                    ?>
                                    @if ($waktuSaatIni->between($jamBuka, $jamTutup))
                                    <span class="badge badge-pill badge-hijau">
                                            {{ __('messages.open') }}
                                        </span>
                                    @else
                                    <span class="badge badge-pill badge-merah">
                                            {{ __('messages.close') }}
                                        </span>
                                    @endif</strong>
                  
                                  <p>
                                   
                                {{ $wisata->jambuka }} S.d {{ $wisata->jamtutup }}
                                  </p>
                  
                                  <hr>
                  
                                  <strong><i class="far fa-file-alt mr-1"></i> {{ __('messages.akomondasi1') }}</strong>
                  
                                  <span class="badge badge-pill badge-biru">{{ $wisata->kapasitas }}</span>
                                  <hr>
                                  <strong><i class="fas fa-person-booth"></i> {{ __('messages.Facilities') }}</strong>
                                  <p>
                                  @foreach ($wisata->fasilitas as $key => $fasilitas)
                                  <span
                                      class="badge badge-pill badge-toska">{{ $fasilitas->fasilitas_name }}</span>
                              @endforeach
                                  </p>
                              <hr>
                              <strong><i class="fas fa-bullhorn"></i> Sosial Media</strong>
                              <p class="text-muted"> <a href="{{ $wisata->instagram }}" class="instagram"> <button type="submit"
                                class="btn btn-outline-orange"><i
                                    class="bx bxl-instagram icon-large"></i></button></a>
                                <a href="{{ $wisata->web }}"> <button type="submit"
                                        class="btn btn-outline-orange"><i
                                            class="bx bxl-opera icon-large"></i></button></a></p>
                                    <hr>
                              <strong><i class="fas fa-receipt"></i> {{ __('messages.priceTicket') }}</strong>
                              <p>
                                  @foreach ($hargatiket as $ticketCategory)
                                      <span class="badge badge-pill badge-orange">
                                          @if ($ticketCategory->harga == 0)
                                              {{ __('messages.Free') }}
                                          @else
                                              {{ $ticketCategory->kategori }} Rp. {{ number_format($ticketCategory->harga, 0, ".", ".") }},-
                                          @endif
                                      </span>
                                      <br>
                                  @endforeach

                                  @if (!$hargatiket->contains('harga', 0))
                                      <div data-v-a81f42ae="" class="row mt-3">
                                          <form
                                              action="{{ route('website.pesantiket', ['wisata_id' => $wisata->id]) }}"
                                              method="GET">
                                              <button type="submit"
                                                  class="btn btn-outline-orange">{{ __('messages.buyTicket') }}</button>
                                          </form>
                                      </div>
                                  @endif
                              </p>
                                        <hr>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $wisata->telpon) }}"
                                            class="btn btn-outline-hijau text-white text-center w-100 fs-15px mt-3"
                                            style="border-radius: 15px; padding: 15px;"><svg 
                                                width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path  fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.7192 25.2333C7.51599 25.2333 2.4873 20.2046 2.4873 14.0014C2.4873 7.79822 7.51599 2.76953 13.7192 2.76953C19.9224 2.76953 24.9511 7.79822 24.9511 14.0014C24.9511 20.2046 19.9224 25.2333 13.7192 25.2333ZM13.2856 15.3639C12.7856 15.8638 12.0218 15.9878 11.3894 15.6716C10.757 15.3554 9.99325 15.4793 9.4933 15.9793L7.79615 17.6764C7.7345 17.7381 7.68805 17.8132 7.66048 17.8959C7.5624 18.1902 7.72142 18.5082 8.01566 18.6063L9.53626 19.1132C10.9965 19.5999 12.6064 19.2199 13.6948 18.1315L18.1867 13.6396C19.1866 12.6397 19.4345 11.1121 18.8021 9.84734L18.0916 8.42635C18.0646 8.37236 18.0291 8.32308 17.9864 8.2804C17.7671 8.06108 17.4115 8.06108 17.1922 8.2804L15.4035 10.0691C14.9035 10.5691 14.7796 11.3329 15.0958 11.9652C15.412 12.5976 15.288 13.3614 14.7881 13.8614L13.2856 15.3639Z"
                                                    fill="white"></path>
                                            </svg> &ensp;{{ $wisata->telpon }}</a>
                                        </div>
                                        <hr>
                                <!-- /.card-body -->
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
                              src="https://maps.google.com/maps?q={{ $wisata->latitude }},{{ $wisata->longitude }}&output=embed"></iframe>
                              <a 
                                  href="https://www.google.com/maps/dir/?api=1&destination={{ $wisata->latitude }},{{ $wisata->longitude }}"
                                  class="btn btn-outline-map text-white text-center w-100 fs-15px mt-3"
                                  style="border-radius: 15px; padding: 15px;"onclick="arahkanSaya('{{ $wisata->latitude }}', '{{ $wisata->longitude }}')">{{ __('messages.directMe') }}</button></a>

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

    <!-- ======= Footer Section ======= -->
    @include('layouts.website.container')
    @include('layouts.website.footer')

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
@endsection
