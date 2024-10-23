@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Article</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="col-12">
                    <div class="card-header">
                            <a class="btn btn-info" href="{{ route('admin.article.edit', $hash->encodeHex($article->id)) }}">
                                <i class="fas fa-edit"></i> Edit</a>
                                <a href="{{ route('admin.article.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                            <div class="card mt-3 col-lg-6">
                                <img src="/upload/article/{{$article->sampul}}" height="450px" alt="...">
                                <div class="card-body">
                                    <h2 class="card-title">{{$article->judul}}</h2>
                                    <p class="card-text">{!!$article->konten!!}</p>
                                    <p class="card-text"><small class="text-muted">{{$article->created_at->diffForHumans()}}</small></p>
                                    <i class="ri-eye-fill"></i>Melihat {{$article->views}}
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</main>