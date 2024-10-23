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
                        <form action="{{route('admin.baners.store')}}"  method="post" enctype="multipart/form-data" >
                            @csrf
                            
                                    <div class="form-group">
                                        <label for="judul">Judul</label><small class="text-success">isi Judul sesuai dengan halaman dengan format :</small>
                                        <br><span class="badge badge-primary">bernda</span>
                                        <span class="badge badge-secondary">destinasi</span>
                                        <span class="badge badge-success">kuliner</span>
                                        <span class="badge badge-danger">akomodasi</span>
                                        <span class="badge badge-warning">acara</span>
                                        <span class="badge badge-info">artikel</span>
                                        <span class="badge badge-success">mobile</span>
                                        <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul')}}">
                                        @error('judul')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="sampul">Sampul</label>
                                        <input type="file" class="form-control" id="sampul" name="sampul">
                                        @error('sampul')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                    
                               
                                
                                <a  href="{{ route('admin.baners.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

