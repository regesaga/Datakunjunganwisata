@extends('layouts.author.account')
@section('content')

<div class="card">
    <div class="card-header">
        Create
    </div>

    <div class="card-body">
    <!-- Page Heading -->
    <form method="POST" action="{{ route("account.ekraf.tag.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Tag</label>
            <input type="text" class="form-control" id="nama" name="nama">
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
        <a href="{{ route("account.ekraf.tag.index") }}" class="btn btn-secondary btn-sm">Kembali</a>
    </form>
    

</div>
</div>
@endsection