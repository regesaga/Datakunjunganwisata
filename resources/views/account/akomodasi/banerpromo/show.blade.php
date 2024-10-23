@extends('layouts.author.account')
@section('content')
<div class="account-layout  border">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                    <a class="btn btn-info" href="{{ route('account.akomodasi.banerpromo.edit', $hash->encodeHex($banerpromo->id)) }}">
                        <i class="fas fa-edit"></i> Edit</a>
                        <a href="{{ route('account.akomodasi.banerpromo.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        <div class="card mt-3">
                            <img src="/upload/banerpromo/{{$banerpromo->sampul}}" class="card-img-top" style="height: 700px; object-fit: cover;" alt="...">

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
@endsection
