@include('layouts.wisatawan.head')

<div class="container">
    <div class="row justify-content-center"style="height: 100vh;">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card card-info w-100">
                <div class="card-header">Daftar Akun</div>
                <div class="card-body">
                    <div class="login-form">
                        <form action="{{route('wisatawan.create-reset-password')}}" method="POST">
                            @csrf
                            {{-- password --}}
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="text" name="id" value="{{ $wisatawan->id }}" hidden>
                                    <input type="text" name="token" value="{{ $wisatawan->password_reset_token }}" hidden>
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required>
                                <span class="input-group-text" id="togglePassword" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                    </div>
                                <input id="password_confirmation" type="password" placeholder="Password(Repeat)" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                                <span class="input-group-text" id="toggleConfirmPassword"
                                onclick="toggleConfirmPasswordVisibility()">
                                <i class="fas fa-eye" id="confirm-eye-icon"></i>
                            </span>

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            <button type="submit" class="btn btn-primary btn-block">Ubah Password</button>
                        </form>
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
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
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
    function toggleConfirmPasswordVisibility() {
        var confirmPasswordInput = document.getElementById("password_confirmation");
        var confirmEyeIcon = document.getElementById("confirm-eye-icon");

        if (confirmPasswordInput.type === "password") {
            confirmPasswordInput.type = "text";
            confirmEyeIcon.classList.remove("fa-eye");
            confirmEyeIcon.classList.add("fa-eye-slash");
        } else {
            confirmPasswordInput.type = "password";
            confirmEyeIcon.classList.remove("fa-eye-slash");
            confirmEyeIcon.classList.add("fa-eye");
        }
    }
</script>

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
