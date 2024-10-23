<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="Kuninganbeu">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal Login Kuningan Beu</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('images/logo/KuninganBeu.png') }}" rel="icon">
    <link href="{{ asset('images/logo/KuninganBeu_Kuning.png') }}" rel="apple-touch-icon">
<link rel="stylesheet" href="{{ asset('admin/kuninganbeu.css')}}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('css/login.css')}}" rel="stylesheet" type="text/css">
   
</head>
<body class="fullscreen-bg">
    <div class="fullscreen-bg" style="background:#3a6a6e;">
       

</div>
<div class="container my-4">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <div class="login-wrap" style="margin-right: 40%;">
                        <form action="{{route('login')}}" method="POST" class="signin-form" style="margin: 0 auto;">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" placeholder="E-mail address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="social d-flex text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Ingatkan Saya
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="/v1/forgot-password" style="color: #fff">Lupa Sandi?</a>
                                </div>
                            </div>
                        </form>
                        
                        <div class="social d-flex text-center">
                            <a href="{{ route('register') }}" class="px-6 py-6 mr-md-1 rounded"> Klik Disini Untuk Daftar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <img src="{{ asset('images/logo/KuninganBeu_Kuning.png') }}" class="img-fluid" >
                </div>
            </div>
        </div>
        
        
	</section>
</div>
</div>

@if (session('success_message'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: '{{ session('success_message') }}',
            customClass: {
                confirmButton: 'btn btn-outline-primary',
            },
            buttonsStyling: false,
        });
    </script>
@endif

<script>
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
<script src="{{ asset('css/jquery.min.js')}}"></script>
<script src="{{ asset('css/main.js')}}"></script>
</body>


</html>