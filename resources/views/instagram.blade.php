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
                <h3 class="fw-bold font-mono text-center">Our <span style="color:#FF269D;">Instagram</span></h3>
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
                                <div style="padding:70px;background-color:#5110e9;">
                                    <img src="{{$media['thumbnail_url']}}" class="card-img-top">
                                </div>
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
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-0" style="box-shadow: 0px 0px 7px 0px #FAF77D;">
                <div class="modal-header">
                    <h1 class="modal-title font-mono fw-bold fs-5" id="exampleModalLabel">Detail Media</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body isiModal">
                    <div class="row">
                        <div class="col-xl-7">
                            <div class="owl-carousel detailMedia owl-theme" id="imageCarousel">
                            </div>
                        </div>
                        <div class="col-xl-5 px-3" style="max-height: 650px; overflow-y: auto;">
                            <p class="card-text caption_ig font-mono" style="text-align: justify;"></p>
                        </div>
                    </div>
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
    <script>
        function nl2br(str, is_xhtml) {
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }
    </script>
    <script>
        $('#exampleModal').on('hidden.bs.modal', function() {
            // Menghentikan video saat modal ditutup
            let videos = document.querySelectorAll('.detailMedia video');
            videos.forEach(video => {
                video.pause();
            });
        });
        $(document).on('click', '.detail_media', function(e) {
    e.preventDefault();
    const id = $(this).attr('data-lihat');
    const loadingShimmerImage = `<div class="skeleton-image-wrapper">
                                    <div class="skeleton-image"></div>
                                </div>`;
    const loadingShimmerCaption = `<div class="skeleton-text">
                            <div class="skeleton-line" style="width: 100%;"></div>
                            <div class="skeleton-line" style="width: 80%;"></div>
                            <div class="skeleton-line" style="width: 60%;"></div>
                            <div class="skeleton-line" style="width: 90%;"></div>
                            <div class="skeleton-line" style="width: 70%;"></div>
                            <div class="skeleton-line" style="width: 50%;"></div>
                            <div class="skeleton-line" style="width: 80%;"></div>
                            </div><div class="skeleton-text mt-2">
                            <div class="skeleton-line" style="width: 50%;"></div>
                            <div class="skeleton-line" style="width: 90%;"></div>
                            <div class="skeleton-line" style="width: 70%;"></div>
                            <div class="skeleton-line" style="width: 70%;"></div>
                            <div class="skeleton-line" style="width: 50%;"></div>
                            <div class="skeleton-line" style="width: 90%;"></div>
                            <div class="skeleton-line" style="width: 60%;"></div>
                            </div>`;

    $('.detailMedia').empty().html(loadingShimmerImage);
    $('.caption_ig').empty().html(loadingShimmerCaption);

    $.ajax({
        url: "{{ url('/detail/media') }}/" + id,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('.skeleton-text').remove();
            $('.skeleton-image-wrapper').remove();

            let datas = response['items'];
            let captionId = $('.caption_ig');
            let username = datas.hasOwnProperty('username') ? datas.username : '';
            captionId.html('<span class="font-sans fw-bold">' + username + '</span>&nbsp;&nbsp;' + nl2br(datas.caption));

            let itemMedias = response['items']['media_url'];
            let html = "";

            // Sisanya kode...

        },
        error: function(xhr, status, error) {
            $('.skeleton-text').remove();
            $('.skeleton-image-wrapper').remove();
        }
    });
});

    </script>
</body>

</html>