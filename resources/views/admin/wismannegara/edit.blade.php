@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
<div class="card">
    <div style="text-align: center; text-transform: uppercase;" class="card-header">
        Ubah Negara
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.wismannegara.update', $hash->encodeHex($wismannegara->id)) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label style="text-align: center; text-transform: uppercase;" class="required" for="name">Nama</label>
                <input style="text-align: left; text-transform: uppercase;" class="form-control" type="text" name="wismannegara_name" id="name" value=" {{$wismannegara->wismannegara_name }}" required>
                
            </div>
            <div class="form-group">
                <button style="text-align: center; text-transform: uppercase;" class="btn btn-outline-danger" type="submit">
                    Simpan
                </button>
            </div>
        </form>


    </div>
</div>
</div>
</section>
@endsection
