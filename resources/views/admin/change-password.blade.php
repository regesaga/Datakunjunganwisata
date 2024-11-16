@extends('layouts.admin.admin')

@section('content')
<main class="main">
  <ol class="breadcrumb">
      <li class="breadcrumb-item active">Password</li>
  </ol>
  <div class="container-fluid">
      <div class="animated fadeIn">
  <div class="account-layout border">
    <div class="account-hdr bg-primary text-white border">
      Change Password
    </div>
    <div class="account-bdy p-3">
      <form action="{{ route('admin.changePassword') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group position-relative">
          <input id="password_hash"  type="password" placeholder="Password Lama *" class="form-control @error('current_password') is-invalid @enderror" name="current_password" value="{{ old('current_password') }}" required>
          <span class="input-group-text position-absolute" id="togglePassword" onclick="togglePasswordVisibility()" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
            <i class="fas fa-eye" id="eye-icon2"></i>
        </span> 
            @error('current_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <p class="mt-3 alert alert-primary">Password must be 8 characters with 1 special character</p>
        <div class="form-group position-relative">
          <input id="passwordnew"  type="password" placeholder="Password Baru*" class="form-control @error('new_password') is-invalid @enderror" name="new_password" value="{{ old('new_password') }}" required>
          <span class="input-group-text position-absolute" id="togglePassword" onclick="togglePasswordNewVisibility()" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
            <i class="fas fa-eye" id="eye-icon3"></i>
        </span>  

            @error('new_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group position-relative">
          <input id="password_confirmation"  type="password" placeholder="Ulangi Password Baru *" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" value="{{ old('confirm_password') }}" required>
          <span class="input-group-text position-absolute" id="togglePassword" onclick="togglePasswordReVisibility()" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
            <i class="fas fa-eye" id="eye-icon1"></i>
        </span>  
            @error('confirm_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="line-divider"></div>
        <div class="mt-3">
          <button type="submit" class="btn primary-btn">Change Password</button>
          <button class="btn primary-outline-btn">Cancel</button>
        </div>
      </form>
    </div>
  </div>
      </div>
  </div>
</main>

<script>
  function togglePasswordVisibility() {
      var passwordInput = document.getElementById("password_hash");
      var eyeIcon = document.getElementById("eye-icon2");

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
<script>
  function togglePasswordReVisibility() {
      var passwordInput = document.getElementById("password_confirmation");
      var eyeIcon = document.getElementById("eye-icon1");

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
<script>
function togglePasswordNewVisibility() {
    var passwordInput = document.getElementById("passwordnew");
    var eyeIcon = document.getElementById("eye-icon3");

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
@endSection
