<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Basic Api Instagram</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Pen+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/instagram.css') }}">

</head>

<body>
    <div class="container bg-splatter-x">
        <div class="header-title my-5">
            <div class="bg-white rounded-1 border border-black d-inline-block text-center px-3 pt-2 mb-3" style="box-shadow: 5px 5px 0px rgba(0, 0, 0, 1);">
                <h3 class="fw-bold font-mono text-center">Our <span style="color:#FF269D;">Instagram FEED</span></h3>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="owl-carousel media owl-theme">
                    @foreach ($mediaData as $media)
                    <a style="text-decoration: none;" class="detail_media" data-bs-toggle="modal" data-bs-target="#exampleModal" role="button" data-lihat="{{$media['id']}}">
                        <div class="item">
                            <div class="card shadow-card rounded-1 border border-black text-bg-light mb-3 mx-2 p-2">
                                @if (isset($media['media_type']) && $media['media_type'] == 'VIDEO')
                                    <img src="{{$media['thumbnail_url']}}" class="card-img-top">
                                @else
                                <img src="{{$media['media_url']}}" class="card-img-top">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title fw-bold font-mono text-start">{{$media['username']}}</h5>
                                    <div class="bisa scroll">
                                        <p class="card-text font-mono five-lines" style="text-align: justify;">{!! nl2br($media['caption']) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="header-title my-5">
            <div class="bg-white rounded-1 border border-black d-inline-block text-center px-3 pt-2 mb-3" style="box-shadow: 5px 5px 0px rgba(0, 0, 0, 1);">
                <h3 class="fw-bold font-mono text-center">Our <span style="color:#FF269D;">Instagram VIDEO</span></h3>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="owl-carousel media owl-theme">
                    @foreach ($mediaData as $media)
                        @if ($media['media_type'] == 'VIDEO')
                            <a style="text-decoration: none;" class="detail_media" data-bs-toggle="modal" data-bs-target="#exampleModal" role="button" data-lihat="{{$media['id']}}">
                                <div class="item">
                                    <div class="card shadow-card rounded-1 border border-black text-bg-light mb-3 mx-2 p-2">
                                            <img src="{{$media['thumbnail_url']}}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold font-mono text-start">{{$media['username']}}</h5>
                                            <div class="bisa scroll">
                                                <p class="card-text font-mono five-lines" style="text-align: justify;">{!! nl2br($media['caption']) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="header-title my-5">
            <div class="bg-white rounded-1 border border-black d-inline-block text-center px-3 pt-2 mb-3" style="box-shadow: 5px 5px 0px rgba(0, 0, 0, 1);">
                <h3 class="fw-bold font-mono text-center">Our <span style="color:#FF269D;">Instagram IMAGE</span></h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="owl-carousel media owl-theme">
                    @foreach ($mediaData as $media)
                        @if ($media['media_type'] == 'IMAGE')
                            <a style="text-decoration: none;" class="detail_media" data-bs-toggle="modal" data-bs-target="#exampleModal" role="button" data-lihat="{{$media['id']}}">
                                <div class="item">
                                    <div class="card shadow-card rounded-1 border border-black text-bg-light mb-3 mx-2 p-2">
                                        <img src="{{$media['media_url']}}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold font-mono text-start">{{$media['username']}}</h5>
                                            <div class="bisa scroll">
                                                <p class="card-text font-mono five-lines" style="text-align: justify;">{!! nl2br($media['caption']) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="header-title my-5">
            <div class="bg-white rounded-1 border border-black d-inline-block text-center px-3 pt-2 mb-3" style="box-shadow: 5px 5px 0px rgba(0, 0, 0, 1);">
                <h3 class="fw-bold font-mono text-center">Our <span style="color:#FF269D;">Instagram ALBUM IMAGE</span></h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="owl-carousel media owl-theme">
                    @foreach ($mediaData as $media)
                        @if (isset($media['media_type']) && $media['media_type'] == 'CAROUSEL_ALBUM' && isset($media['images']))
                            <a style="text-decoration: none;" class="detail_media" data-bs-toggle="modal" data-bs-target="#exampleModal" role="button" data-lihat="{{$media['id']}}">
                                <div class="item">
                                    <div class="card shadow-card rounded-1 border border-black text-bg-light mb-3 mx-2 p-2">
                                        @foreach ($media['images'] as $image)
                                            <img src="{{$image['url']}}" class="card-img-top">
                                        @endforeach
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold font-mono text-start">{{$media['username']}}</h5>
                                            <div class="bisa scroll">
                                                <p class="card-text font-mono five-lines" style="text-align: justify;">{!! nl2br($media['caption']) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        
        
                
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.media').owlCarousel({
            loop: true,
            margin: 10,
            animateOut: 'slideOutDown',
            animateIn: 'flipInX',
            autoplay: true,
            dots: false,
            autoplayTimeout: 7000,
            autoplayHoverPause:false,
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
    </script>
   
</body>

</html>