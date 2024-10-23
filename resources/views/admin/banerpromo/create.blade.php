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
                    <div class="card-body">
                        <form action="{{route('admin.banerpromo.store')}}"  method="post" enctype="multipart/form-data" >
                            @csrf
                            
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul')}}">
                                        @error('judul')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="sampul">Sampul</label><small class="text-warning">Pastikann Ukuran Baner Promo 1074 x 258 px</small>
                                        <small class="text-warning">Pastikann Ukuran Baner Promo 1074 x 258 px</small>
                                        <input type="file" class="form-control" id="sampul" name="sampul">
                                        @error('sampul')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        Status
                                        <select name="active" class="form-control" required>
                                            <option value="1" {{ old('active') == '1' ? 'selected':'' }}>Publish</option>
                                            <option value="0" {{ old('active') == '0' ? 'selected':'' }}>Draft</option>
                                        </select>
                                        <p class="text-danger">{{ $errors->first('active') }}</p>
                                    </div> 
                    
                               
                                
                                <a  href="{{ route('admin.banerpromo.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

