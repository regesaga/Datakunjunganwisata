@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card py-4">
                <div class="card-body">
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success text-center">Tautan verifikasi email baru telah dikirim ke email Anda!</div>
                    @endif
                    <div class="text-center mb-5">
                        
                        <h3>Verifikasi alamat email</h3>
                        <p>Anda harus memverifikasi alamat email Anda untuk mengakses halaman ini.</p>
                    </div>
                    <form method="POST" action="{{ route('verification.send') }}" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-primary">Mengirim ulang email verifikasi</button>
                    </form>
                </div>
                
                <p class="mt-3 mb-0 text-center"><small>
                    <br>Silakan mendaftar dengan <a href="/register-retry">alamat email yang lain.</a></small></p>
            </div>
        </div>
    </div>
</div>
@endsection