@include('layouts.wisatawan.head')
<!-- Font Awesome CSS -->

<style>
    .input-group-text {
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="row justify-content-center"style="height: 100vh;">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card card-info w-100">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('wisatawan.auth-authenticate') }}" >
                        @csrf
                        <div class="mb-3">
                            <input id="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}" placeholder="Email atau Nomor Telepon" required autofocus>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input id="password_hash" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required value="{{ old('password') }}" placeholder="Kata Sandi">
                                <span class="input-group-text" id="togglePassword" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                            @enderror
                        </div>
                        <div class="d-sm-flex justify-content-between align-items-center mt-2">
                            <div class="check-box form-check">
                                <label class="form-check-label  control-label">
                                    <input class="form-check-input" type="checkbox" value=""
                                        style="left: -9999px !important;">
                                    <span class="form-check-sign">Remember Me</span>
                                </label>
                            </div>
                            <a title="Forgot Password" class="forgot-password"
                                href="{{ route('wisatawan.forgot-password') }}">Forgot
                                password?</a>
                        </div>

                        <div class="login-btn mt-3">
                            <button name="submit" type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-sign-in-alt"></i><span> Log In</span>
                            </button>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('wisatawan.registration') }}" class="btn btn-secondary btn-lg w-100"><i
                                    class="fas fa-user-plus"></i> Daftar
                                Akun</a>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('redirect') }}" class="btn btn-danger"><i class="fab fa-google"></i> Login
                                dengan Google</a>
                        </div>

                    </form>
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

    
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password_hash");
        var eyeIcon = document.getElementById("eye-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
