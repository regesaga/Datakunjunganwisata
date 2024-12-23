@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div style="text-align: center; text-transform: uppercase;" class="card-header">
                Tambah Kelompok
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("admin.kelompokkunjungan.storekelompokkunjungan") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label style="text-align: center; text-transform: uppercase;" class="required" for="name">Nama Kelompok</label>
                        <input style="text-align: center; text-transform: uppercase;" class="form-control {{ $errors->has('kelompokkunjungan_name') ? 'is-invalid' : '' }}" type="text" name="kelompokkunjungan_name" id="kelompokkunjungan_name" value="{{ old('kelompokkunjungan_name', '') }}" required>
                        @if($errors->has('kelompokkunjungan_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    
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