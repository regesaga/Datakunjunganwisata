<div class="login-banner d-none d-md-block border-top">
  <div class="container p-3">
    <div class="d-flex justify-content-center align-items-center">
      <a href="{{route('register')}}" class="primary-outline-btn mr-4">Daftar</a>
      <a href="{{route('login')}}" class="primary-outline-btn mr-4">Masuk</a>
      <a href="{{route('login')}}" class="secondary-link">Apaka anda seorang Pengelola?</a>
    </div>
  </div>
</div>


@push('css')
  <style>
    .login-banner{cd
    }
    .login-banner-text{
      font-size:1.6rem;
      color:#185A91;
    }
  </style>
@endpush