@extends('layouts.author.account')


@section('content')
  <div class="account-layout border">
    <div class="account-hdr bg-primary text-white border">
      Isi Profil Penanggung jawab Usaha
    </div>
    <div class="account-bdy p-3">
     <form action="{{route('account.akomodasi.company.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <div class="py-3">
            <p>Nama Pemilik USaha</p>
          </div>
          <input type="text"  class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="pt-2">
          <p class="mt-3 alert alert-primary">isi deskripsi paragraf singkat tentang usaha Anda</p>
        </div>
        <div class="form-group">
          <textarea class="form-control @error('title') is-invalid @enderror" name="title" required>{{ old('title') }}</textarea>
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
          <div class="py-3">
            <p>Bidang Usaha</p>
          </div>
          <input type="text" class="form-control @error('ijin') is-invalid @enderror" name="ijin" value="{{ old('ijin')}}" required>
            @error('ijin')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
          <div class="py-3">
            <p>Telp/No Hp</p>
          </div>
          <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


       

        
   
        <div class="line-divider"></div>
        <div class="mt-3">
          <button type="submit" class="btn primary-btn">Isi detail Penyedia</button>
          <a href="{{route('account.akomodasi.user-akomodasi')}}" class="btn primary-outline-btn">Cancel</a>
        </div>
      </form>
    </div>
  </div>
  
@endsection
