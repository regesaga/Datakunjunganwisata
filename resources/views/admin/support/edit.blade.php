@include('layouts.admin.admin')
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Support</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
<div class="col-12">
    <div class="card">
        <div class="card-header">
    <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Support By</h1>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("admin.support.update", $hash->encodeHex($support->id)) }}"   enctype="multipart/form-data" >
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <img src="/upload/support/{{$support->sampul}}" width="150px" height="150px" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul') ? old('judul') : $support->judul}}">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="sampul">Logo</label>
                            <input type="file" class="form-control" id="sampul" name="sampul">
                            @error('sampul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.support.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                
            </form>

        </div>
    </div>
</div>
        </div>
    </div>
</main>