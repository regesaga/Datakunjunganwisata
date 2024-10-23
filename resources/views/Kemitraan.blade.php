
  <!doctype html>
  <html>
  <head>
      <meta charset="utf-8">
      <meta name="description" content="Portal Sistem Informasi Pariwisata">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Portal Sistem Informasi Pariwisata</title>
  <link href="{{ asset('icon/KuninganBeu.png')}}" rel="icon">
  <link href="{{ asset('icon/KuninganBeu_Kuning.png')}}" rel="apple-touch-icon">
  <link rel="stylesheet" href="{{ asset('admin/flash.css')}}">
  <link href="{{ asset('admin/custome/roboto.css')}}" rel="stylesheet" type="text/css">
  <link href="{{ asset('admin/custome/Style.css')}}" rel="stylesheet" type="text/css">
  <link href="{{ asset('admin/custome/style.bundle.min.css')}}" rel="stylesheet" type="text/css">
              <!--end::Web font -->
      
              <!--begin::Base Styles -->
              <!--end::Base Styles -->
         <style>
             * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
}

.fullscreen-bg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    z-index: -1;
    background:#3a6a6e;
}

.bg-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.content {
    padding: 40px;
    text-align: center;
}

.m-login__signin {
    margin-top: 2rem;
}

.m-login__head {
    margin-bottom: 2rem;
}

.m-login__title {
    font-size: 35px;
    text-shadow: 2px 2px rgba(252, 252, 252, 0.993);
}

/* .img-shadow {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
} */

.card-halaman {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease-in-out;
}

.card-halaman:hover {
    transform: translateY(-5px);
}

.card-halaman img {
    width: 60px;
    height: 60px;
    margin-bottom: 10px;
}

.card-halaman h4 {
    font-size: 18px;
    font-weight: bold;
    color: #fff;
}

</style>
  </head>
  <body>
  <div class="fullscreen-bg">
  <video loop muted autoplay poster class="bg-video">
      <source src="{{ asset('admin/flash.mp4') }}"  type="video/mp4">
  
  </video>
  </div>
  <div class="content col-xs-12 col-sm-12 col-md-6 m-auto text-center">
  
      <div class="m-login__signin">
          <div class="m-login__head text-center">
              <h3 class="m-login__title" style="font-size: 35px; text-shadow: 2px 2px rgba(252, 252, 252, 0.993);margin-top: 2rem">
                  Portal Informasi Wisata
                                                        </h3>
                {{-- <img src="{{asset('images/logo/kuningankab.png')}}" alt="logo" class="img-shadow" width="150">
                <img src="{{asset('images/logo/disporapar.png')}}" alt="logo" class="img-shadow" width="250"> --}}
                <img src="{{asset('images/logo/KuninganBeu_Putih.png')}}" alt="logo" class="img-shadow" width="150">
  
          </div>
          <form class="m-login__form m-form" action="">
              <div class="m-login__form-action">
                  <div class="row mt-5 justify-content-center">
                      <div class="col-6 col-lg-4 mb-6">
                          <a href="{{ route('home') }}" class="stretched-link">
                              <div class="card card-halaman">
                                  <div class="card-body text-center">
                                      <img src="https://online.digitaldesa.id/templates/homepage/img/icon_fitur/digides_administrasi.svg">
                                      <h4>Website</h4>
                                  </div>
                              </div>
                          </a>
                      </div>
                      <div class="col-6 col-lg-4 mb-4">
                          <a href="{{ route('login') }}" class="stretched-link">
                              <div class="card card-halaman">
                                  <div class="card-body text-center">
                                      <img src="https://online.digitaldesa.id/templates/homepage/img/icon_fitur/digides_resepsionis.svg">
                                      <h4>Login</h4>
                                  </div>
                              </div>
                          </a>
                      </div>
                   
                  </div>
              </div>
          </form>
          
      </div>
  
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(sendPositionToServer, handleGeolocationError);
        } else {
            alert("Geolocation is not supported by this browser.");
            redirectToHomePage();
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
                redirectToHomePage();
            }
        }).catch(error => {
            console.log("Error logging location:", error);
            redirectToHomePage();
        });
    }
    
    function handleGeolocationError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("Anda harus mengizinkan akses lokasi untuk menggunakan halaman ini.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Informasi lokasi tidak tersedia.");
                break;
            case error.TIMEOUT:
                alert("Permintaan untuk mendapatkan lokasi pengguna habis waktu.");
                break;
            case error.UNKNOWN_ERROR:
                alert("Terjadi kesalahan yang tidak diketahui.");
                break;
        }
        redirectToHomePage();
    }
    
    function redirectToHomePage() {
        window.location.href = '/'; // Ganti '/' dengan URL halaman utama (Home) Anda
    }
</script>

    
  </body>
  </html>