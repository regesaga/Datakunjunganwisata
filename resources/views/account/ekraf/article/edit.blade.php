@extends('layouts.author.account')
@section('content')
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Artticle Edit</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("account.ekraf.article.update", $hash->encodeHex($article->id)) }}"   enctype="multipart/form-data" >
                            @method('PUT')
                            @csrf
                <!-- Page Heading -->
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul') ? old('judul') : $article->judul}}">
                        @error('judul')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <img src="/upload/article/{{$article->sampul}}" width="100%" height="150px" class="mt-2" alt="">
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="sampul">Sampul</label>
                                <input type="file" class="form-control" id="sampul" name="sampul">
                                @error('sampul')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="tag">Tag</label>
                        <select multiple class="form-control" id="tag" name="tag[]">
                            @foreach ($tag as $row)
                                <option value="{{$row->id}}"
                                    @foreach ($article->tag as $tag_lama)
                                        @if ($tag_lama->id == $row->id)
                                            selected
                                        @endif
                                    @endforeach
                                >{{$row->nama}}</option>
                            @endforeach
                        </select>
                        @error('tag')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Konten</label>
                        <textarea class="form-control" id="deskripsi" rows="10" name="konten">{{old('konten') ? old('konten') : $article->konten}}</textarea>
                        @error('konten')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        Status   
                        <select name="active" class="form-control" required>
                            <option value="1" {{ $article->active == '1' ? 'selected':'' }}>Publish</option>
                            <option value="0" {{ $article->active == '0' ? 'selected':'' }}>Draft</option>
                        </select>
                        
                        @if($errors->has('active'))
                            <div class="invalid-feedback">
                                {{ $errors->first('active') }}
                            </div>
                        @endif
                    </div> --}}
                
                    <a href="{{ route('account.ekraf.article.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    <button type="submit" class="btn btn-primary btn-sm">Edit</button>

                </form>

            </div>

            @push('scripts')
            <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('deskripsi');
            </script>
            @endpush
            @endsection