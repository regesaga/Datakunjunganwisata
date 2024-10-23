@extends('layouts.author.wisatawan')

@section('content')
    <div class="account-bdy p-3">
        <section class="author-company-info">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card card-info w-100">
                            <div class="card-header">Ubah Profile</div>
                            <div class="card-body">
                                <div class="login-form">
                                    <form method="POST" action="{{ route("wisatawan.update",$wisatawan->id) }}"   method="POST" enctype="multipart/form-data"  onsubmit="return validateForm()">
                                        @csrf
                                        @method('PUT')

                                        {{-- password --}}
                                        <div class="form-group">
                                            <strong>Name:</strong>
                                            <input type="text" name="name" placeholder="Name" value="{{ $wisatawan->name }}"
                                                class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <strong>Phone:</strong>
                                            <input type="number" name="phone" placeholder="Phone" value="{{ $wisatawan->phone }}"
                                                class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <strong>Email:</strong>
                                            <input type="text" name="email" placeholder="Email" value="{{ $wisatawan->email }}"
                                                class="form-control" readonly>
                                        </div>


                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                            class="fas fa-lock"></i></span>
                                                </div>
                                                <input id="password" type="password" placeholder="Password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" value="{{ old('password') }}" required>
                                                <span class="input-group-text" id="togglePassword"
                                                    onclick="togglePasswordVisibility()">
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
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                            class="fas fa-lock"></i></span>
                                                </div>
                                                <input id="confirm-password" type="password"
                                                    placeholder="Password(Repeat)"
                                                    class="form-control @error('confirm-password') is-invalid @enderror"
                                                    name="confirm-password" value="{{ old('confirm-password') }}"
                                                    required>
                                                <span class="input-group-text" id="toggleConfirmPassword"
                                                    onclick="toggleConfirmPasswordVisibility()">
                                                    <i class="fas fa-eye" id="confirm-eye-icon"></i>
                                                </span>

                                                @error('confirm-password')
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
        </section>
    </div>
@endSection




@push('scripts')
    @if (session('success_message'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Info',
                // text: 'asdasd',
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
            var confirmPasswordInput = document.getElementById("confirm-password");
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
@endpush
