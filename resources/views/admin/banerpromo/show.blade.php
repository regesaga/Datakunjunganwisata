@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Baner Promo</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-12">
    <div class="card">
        <div class="card-header">
                <a class="btn btn-info" href="{{ route('admin.banerpromo.edit', $hash->encodeHex($banerpromo->id)) }}">
                    <i class="fas fa-edit"></i> Edit</a>
                    <a href="{{ route('admin.banerpromo.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    <div class="card mt-3">
                        <img src="/upload/banerpromo/{{$banerpromo->sampul}}" class="card-img-top"  alt="...">

                        <div class="card-body">
                            <h2 class="card-title">{{$banerpromo->judul}}</h2>
                            <p class="card-text">{!!$banerpromo->konten!!}</p>
                            <p class="card-text"><small class="text-muted">{{$banerpromo->created_at->diffForHumans()}}</small></p>
                        </div>
                    </div>

        </div>
    </div>
</div>
        </div>
    </div>
</main>