@include('layouts.wisatawan.head')

<div class="container">
    <div class="row justify-content-center"style="height: 100vh;">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card card-info w-100">
                <div class="card-header">Lupa Password</div>
                <div class="card-body">
                    <div class="login-form">
                        <form action="{{route('wisatawan.reset-password')}}" method="GET">
                            @csrf
                            {{-- email --}}
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    </div>
                                <input id="email" type="email" placeholder="E-mail " class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                        </form>
                        <div class="my-3">
                            <p>Sudah Mempunyai Akun? <a href="{{ route('wisatawan.login') }}">Masuk Sekarang</a></p>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.wisatawan.script')

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


@push('css')
<style>
.login-poster {
    /* fallback */
   background-image: url('{{asset("images/login-background.png")}}');
    background-image: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.35)
        ),
        url('{{asset("images/login-background.png")}}');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
</style>
@endpush
