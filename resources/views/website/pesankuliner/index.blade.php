<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Kuningan Beu</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('images/logo/KuninganBeu.png') }}" rel="icon">
    <link href="{{ asset('images/logo/KuninganBeu_Kuning.png') }}" rel="apple-touch-icon">
    <!-- Online -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->

    <link href="{{ asset('Frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('Frontend/assets/css/slick-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/css/style.mobile.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('Frontend/assets/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('Frontend/assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('Frontend/assets/css/owl.carousel2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('Frontend/assets/css/owl.carousel3.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('Frontend/assets/css/owl.carousel4.min.css') }}" rel="stylesheet" type="text/css">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">

    <style>
        .language-dropdown ul {
            display: none;
            position: absolute;
            background-color: #fff;
            /* Ganti dengan warna yang diinginkan */
            padding: 10px;
            border: 1px solid #ccc;
            /* Ganti dengan warna yang diinginkan */
        }

        .language-dropdown ul li a {
            color: #000;
            /* Teks menjadi hitam */
            text-decoration: none;
            /* Menghapus garis bawah */
        }

        .language-dropdown:hover ul {
            display: block;
        }
    </style>
</head>

<body>

    <header id="header" class="fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="logo me-auto">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" alt=""
                        style="height: 100px; width: auto; margin-right: 3px;">
                </a>
            </h1>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class=" scrollto" href="{{ route('website.articel') }}">{{ __('messages.articel') }}</a>
                    </li>
                    <li><a class=" scrollto" href="{{ route('website.destinasi') }}">{{ __('messages.tour') }}</a>
                    </li>
                    <li><a class=" scrollto" href="{{ route('website.kuliner') }}">{{ __('messages.culinary') }}</a>
                    </li>
                    <li><a class=" scrollto"
                            href="{{ route('website.akomodasi') }}">{{ __('messages.accommodation') }}</a></li>
                    <li><a class=" scrollto" href="{{ route('website.event') }}">{{ __('messages.event') }}</a></li>
                    <li><a class=" scrollto"
                            href="{{ route('website.petawisata') }}">{{ __('messages.touristMap') }}</a>
                    </li>
                    <li><a class=" scrollto"
                        href="{{ route('kemitraan') }}">{{ __('messages.partner') }}</a>
                    </li>
                    <li><a class="btn-sign" href="{{ route('wisatawan.login') }}"><i class="fa fa-sign-in"></i> {{ __('messages.login') }}</a></li>
                    <li class="language-dropdown">
                        <a class="scrollto" href="#bahasa">
                            {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }} &nbsp;<i class="fas fa-sort-down"></i>
                            <!-- Ikon drop-down dari Font Awesome -->
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('change_locale', ['locale' => 'id']) }}">Indonesia</a></li>
                            <li><a href="{{ route('change_locale', ['locale' => 'en']) }}">English</a></li>
                        </ul>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>

    <!-- ======= Hero Section ======= -->
  

    <main id="main">
        <!-- ======= Wisata Section ======= -->
        <section id="destinasi" class="destinasi">
            <div class="container">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="cardarticle-slider">
                                @foreach ($kuliner->photos as $key => $media)
                                    <div class="cardarticle-wrapper">
                                        <article class="cardarticle">
                                                <picture class="cardarticle__background">
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        <img src="{{ $media->getUrl() }}" alt="Foto" width="auto" height="450">
                                                    </a>
                                                </picture>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Pesan Kuliner {{$kuliner->namakuliner}}</h3>
                        </div>
                    </div>
                  
                    
                     
                    <form method="POST" onsubmit="return submitForm();">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="bd-example-snippet bd-code-snippet mb-5">
                                            <div class="bd-example m-0 border-0">
          
                                              <div class="row overflow-auto px-2" id="tickets" style="max-height:280px ">
                                                @foreach ($kulinerproduk as $index => $kulinerproduk)
                                                              
                                                  <div class="callout callout-primary p-3 my-2 ">
                                                                <div class="row" style="padding-top: 0px">
                                                                    <div class="col-6">
                                                                      <p class="tix-cat">{{$kulinerproduk->nama }}</p>
                                                                        @foreach($kulinerproduk->photos as $key => $media)
                                                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                                                <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                                                            </a>
                                                                        @endforeach
                                                                      <input type="hidden" name="kulinerproduk_id[]"class="form-control" required value="{{ $kulinerproduk->id }}" readonly>
                                                                      <input type="hidden" class="form-control" name="nama[]" required value="{{ $kulinerproduk->nama }}" readonly>
                                                                      <input type="hidden" name="harga[]" class="form-control" required value="{{ $kulinerproduk->harga }}" readonly>
                                                                      <strong style="font-size: 14px;" class="text-dark">Rp. {{ number_format($kulinerproduk->harga, 0, ".", ".") }},- </strong>
                                                                    </div>
                                                                    <div class="col-6">
                                                                      <strong style="font-size: 14px;" class="text-dark align-items-center justify-content-center">Jumlah</strong>
                                                                      <div class="input-group" >
          
                                                                          <button type="button" class="btn btn-outline-secondary btn-number mx-0 p-1" data-type="minus"><i class="bi-dash-lg"></i></button>
                                                                          <input type="text" name="jumlah[]" class="form-control input-number" value="0" min="0" max="20" required onchange="calculateTotal()">
                                                                          <button type="button" class="btn btn-outline-secondary btn-number mx-0 p-1" data-type="plus"><i class="bi-plus-lg"></i></button>
                                                                      </div>
                                                                    </div>
                                                                </div>
          
                                                              </div>
                                                     @endforeach
                                                </div>
                                            </div>
                                          </div>

                                       
                                    </div>

                                        <div class="col-md-4">
                                            <div class="card card-primary" style="padding: 10px">
                                                
                                                <div class="row">

                                                    <div class="col-lg-6">
                                                    <input type="hidden" name="kuliner_id"class="form-control" required value="{{ $kuliner->id }}" readonly>
                                                    <input type="hidden" name="namakuliner"class="form-control" required value="{{ $kuliner->namakuliner }}" readonly>

                                                        <label>Total Jumlah</label>
                                                        <input type="text" id="totalJumlah" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Total Harga</label>
                                                        <input type="text" id="totalHarga" name="totalHarga" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                    <label>Pilih Tanggal Kunjungan</label>
                                                    <input type="date" id="tanggalkunjungan" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                    <input type="radio" name="metodepembayaran" value="Online" checked> Bayar Sekarang
                                                    <input type="radio" name="metodepembayaran" value="Tunai"> Bayar di Loket
                                                    </div>
                                                </div>
                                            
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="submit"  id="pay-button" class="submit">Pesan Sekarang</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                </form>
            </div>
                
                </section><!-- End Pricing Section -->
                </main><!-- End #main -->
                
             
                <!-- Vendor JS Files -->
                
                <!-- Template Main JS File -->
                  
                <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
                
                <script>
                    function calculateTotal() {
                        var totalJumlah = 0;
                        var totalHarga = 0;
                        var jumlahInputs = document.getElementsByName('jumlah[]');
                        var hargaInputs = document.getElementsByName('harga[]');
                
                        for (var i = 0; i < jumlahInputs.length; i++) {
                            var jumlah = parseInt(jumlahInputs[i].value) || 0;
                            var harga = parseInt(hargaInputs[i].value) || 0;
                
                            totalJumlah += jumlah;
                            totalHarga += jumlah * harga;
                        }
                
                        document.getElementById('totalJumlah').value = totalJumlah;
                        document.getElementById('totalHarga').value = totalHarga;
                    }
                
                    $(document).ready(function() {
                        $(".btn-number").on("click", function(e) {
                            e.preventDefault();
                            var type = $(this).data('type');
                            var input = $(this).siblings('.input-number');
                            var currentVal = parseInt(input.val()) || 0;
                
                            if (type === 'minus' && currentVal > input.attr('min')) {
                                input.val(currentVal - 1);
                            } else if (type === 'plus' && currentVal < input.attr('max')) {
                                input.val(currentVal + 1);
                            }
                
                            calculateTotal();
                        });
                
                        $(".input-number").on("change", function() {
                            calculateTotal();
                        });
                    });
                </script>
                <script>
  function submitForm() {
    var tanggalKunjungan = new Date($('#tanggalkunjungan').val());
    var tanggalSekarang = new Date();
    var batasMaksimal = new Date();
    batasMaksimal.setDate(tanggalSekarang.getDate() + 7);

    // Set the time portion of the current date and the maximum date to 00:00:00
    tanggalSekarang.setHours(0, 0, 0, 0);
    batasMaksimal.setHours(0, 0, 0, 0);

    // Set the time portion of the selected date to 00:00:00
    tanggalKunjungan.setHours(0, 0, 0, 0);

    // Check if the selected date is not today or within the next 7 days
    if (tanggalKunjungan.getTime() < tanggalSekarang.getTime() || tanggalKunjungan.getTime() > batasMaksimal.getTime()) {
        alert('Tanggal kunjungan harus dipilih sebagai tanggal sekarang atau dalam 7 hari ke depan');
        return false; // Stop form submission
    }

    var formData = {
        _token: '{{ csrf_token() }}',
        kuliner_id: $('input[name="kuliner_id"]').val(),
        namakuliner: $('input[name="namakuliner"]').val(),
        tanggalkunjungan: $('#tanggalkunjungan').val(),
        metodepembayaran: $('input[name="metodepembayaran"]:checked').val(),
        totalHarga: $('input[name="totalHarga"]').val(),
        kulinerproduk_id: $('input[name="kulinerproduk_id[]"]').map(function(){ return this.value; }).get(),
        nama: $('input[name="nama[]"]').map(function(){ return this.value; }).get(),
        harga: $('input[name="harga[]"]').map(function(){ return this.value; }).get(),
        jumlah: $('input[name="jumlah[]"]').map(function(){ return this.value; }).get()
    };

    $.post("{{ route('pesankuliner.store') }}", formData)
        .done(function(data) {
            if (data.status == 'error') {
                alert(data.message);
            } else {
                if (formData.metodepembayaran === 'Online') {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log("Payment successful");
                            window.location.href = "{{ route('website.pesankuliner.checkout_finish', ['pesankuliner' => ':kodepesanan']) }}".replace(':kodepesanan', data.kodepesanan);
                        },
                        onPending: function(result) {
                            console.log("Payment pending");
                            window.location.href = "{{ route('wisatawan.home')}}";
                        },
                        onError: function(result) {
                            console.log("Payment error");
                            location.reload(); // Reload the page after payment error
                        },
                        onClose: function(){
                            console.log("Payment Closed");
                            window.location.href = "{{ route('website.pesankuliner.checkout_finish', ['pesankuliner' => ':kodepesanan']) }}".replace(':kodepesanan', data.kodepesanan);
                        }
                    });
                } else {
                    // Jika metode pembayaran adalah "Tunai"
                    window.location.href = "{{ route('website.pesankuliner.checkout_finish', ['pesankuliner' => ':kodepesanan']) }}".replace(':kodepesanan', data.kodepesanan);
                }
            }
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", error);
            // Handle AJAX errors
        });

    return false; // Prevent form submission
}

                    </script>


@include('layouts.website.container')
@include('layouts.website.footer')

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>


    <!-- Vendor JS Files -->

    <!-- Template Main JS File -->

    <script src="{{ asset('Frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('Frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('Frontend/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    {{-- <script src="{{ asset('Frontend/carosel/js/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('Frontend/carosel/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('Frontend/carosel/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web-animations/2.3.1/web-animations.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.3.1/smooth-scrollbar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script>
        jQuery('.cardarticle-slider').slick({
               slidesToShow: 3,
               autoplay: true,
               loop: true,
               slidesToScroll: 1,
               autoplayHoverPause: true,
               dots: false,
               prevArrow: false,
               nextArrow: false,
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
            document.addEventListener('DOMContentLoaded', (event) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(sendPositionToServer, showError);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });
            
            function sendPositionToServer(position) {
                fetch('/log-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    })
                }).then(response => {
                    if (response.ok) {
                        console.log("Location logged successfully");
                    } else {
                        console.log("Failed to log location");
                    }
                }).catch(error => {
                    console.log("Error logging location:", error);
                });
            }
            
            function showError(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        alert("Terimakasih.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        alert("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("An unknown error occurred.");
                        break;
                }
            }
            </script>
            
</body>

</html>
