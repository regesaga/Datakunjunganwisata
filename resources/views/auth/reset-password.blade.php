@<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="Portal Visit Kuningan">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal Visit Kuningan</title>
<link rel="stylesheet" href="{{ asset('admin/flash.css')}}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('css/login.css')}}" rel="stylesheet" type="text/css">
            <!--end::Web font -->
    
        <style type="text/css">span.im-caret {
        -webkit-animation: 1s blink step-end infinite;
        animation: 1s blink step-end infinite;
    }
    
    @keyframes blink {
        from, to {
            border-right-color: black;
        }
        50% {
            border-right-color: transparent;
        }
    }
    
    @-webkit-keyframes blink {
        from, to {
            border-right-color: black;
        }
        50% {
            border-right-color: transparent;
        }
    }
    
    span.im-static {
        color: grey;
    }
    
    div.im-colormask {
        display: inline-block;
        border-style: inset;
        border-width: 2px;
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
    }
    
    div.im-colormask > input {
        position: absolute;
        display: inline-block;
        background-color: transparent;
        color: transparent;
        -webkit-appearance: caret;
        -moz-appearance: caret;
        appearance: caret;
        border-style: none;
        left: 0; /*calculated*/
    }
    
    div.im-colormask > input:focus {
        outline: none;
    }
    
    div.im-colormask > input::-moz-selection{
        background: none;
    }
    
    div.im-colormask > input::selection{
        background: none;
    }
    div.im-colormask > input::-moz-selection{
        background: none;
    }
    
    div.im-colormask > div {
        color: black;
        display: inline-block;
        width: 100px; /*calculated*/
    }</style><style type="text/css">/* Chart.js */
    @-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style></head>
      
</head>
<body class="js-fullheight">
<div class="fullscreen-bg">
<video loop muted autoplay poster="poster.jpg" class="bg-video">
    <source src="{{ asset('admin/flash.mp4') }}"  type="video/mp4">

</video>
</div>
<div class="container my-4">
    <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
                    <img src="{{asset('images/logo/kuninganBeu.png')}}" alt="logo" class="img-shadow" width="120">
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
        
                    <form action="/v1/reset-password" method="post">
                        @csrf
        
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
                        <div class="form-group">
                            <label class="font-weight-bold text-uppercase">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $request->email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan Alamat Elamil">
                            @error('email')
                            <div class="alert alert-danger mt-2">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label class="font-weight-bold text-uppercase">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder="Masukkan Password Baru">
                            @error('password')
                            <div class="alert alert-danger mt-2">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label class="font-weight-bold text-uppercase">Konfirmasi Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password" placeholder="Masukkan Konfirmasi Password Baru">
                        </div>
        
                        <button type="submit" class="btn btn-primary btn-block">RESET PASSWORD</button>
                    </form>
        
                </div>
                
              </div>
				</div>
			</div>
		</div>
	</section>
</div>
</div>
<script src="{{ asset('css/jquery.min.js')}}"></script>
<script src="{{ asset('css/main.js')}}"></script>
</body>


</html>