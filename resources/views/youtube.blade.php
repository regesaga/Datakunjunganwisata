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
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .item img {
            width: 100%; /* Menetapkan lebar gambar 100% dari elemen parent */
            max-width: 100%; /* Memastikan lebar gambar tidak melebihi lebar aslinya */
            height: 300px; /* Menetapkan tinggi gambar sesuai kebutuhan Anda */
            object-fit: cover; /* Memastikan gambar tetap proporsional dan mengisi elemen parent */
        }
    </style>
</head>

<body>
    <div class="container bg-splatter-x">


        <div class="row mt-3">
            <div class="col-lg-7">
                <div class="owl-carousel media owl-theme">
                    <a style="text-decoration: none;" href="">
                        <div class="item">
                        <img src="https://babelprov.go.id/images/website/banner-asean.png" width="100%" alt="KEKETUAAN ASEAN INDONESIA 2023" />
                        </div>
                    </a>
                    <a style="text-decoration: none;" href="">
                        <div class="item">
                        <img src="{{ asset('images/lapor.jpg') }}" width="100%" alt="KEKETUAAN ASEAN INDONESIA 2023" />
                        </div>
                    </a>
                    <a style="text-decoration: none;" href="">
                        <div class="item">
                        <img src="{{ asset('images/bantal.jpg') }}" width="100%"  alt="KEKETUAAN ASEAN INDONESIA 2023" />
                        </div>
                    </a>
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
            // nav: true,
            navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    </script>
</body>

</html>