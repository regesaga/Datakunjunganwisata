@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Baner</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-12">
    <div class="card">
        <div class="card-header">
                <a class="btn btn-info" href="{{ route('admin.baners.edit', $hash->encodeHex($banner->id)) }}">
                    <i class="fas fa-edit"></i> Edit</a>
                    <a href="{{ route('admin.baners.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    <div class="card mt-3">
                        <img src="/upload/banner/{{$banner->sampul}}" class="card-img-top" style="height: 700px; object-fit: cover;" alt="...">

                        <div class="card-body">
                            <h2 class="card-title">{{$banner->judul}}</h2>
                            <p class="card-text">{!!$banner->konten!!}</p>
                            <p class="card-text"><small class="text-muted">{{$banner->created_at->diffForHumans()}}</small></p>
                        </div>
                    </div>

        </div>
    </div>
</div>
        </div>
    </div>
</main>