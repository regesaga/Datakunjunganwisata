@extends('layouts.author.account')
@section('content')

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    
                        <h1 class="h3 mb-4 text-gray-800">Article</h1>

                        <form action="{{route('account.ekraf.article.store')}}"  method="post" enctype="multipart/form-data"  onsubmit="return validateForm()">
                            @csrf
                            <div class="form-group">
                                <label for="judul">Judul</label>
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
                        
                            <div class="form-group">
                                <label for="tag">Tag</label>
                                <select multiple class="form-control" id="tag" name="tag[]">
                                    @foreach ($tag as $row)
                                        <option value="{{$row->id}}">{{$row->nama}}</option>
                                    @endforeach
                                </select>
                                @error('tag')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Konten</label>
                                <textarea class="form-control" id="deskripsi" rows="10" name="konten" required>{{old('konten')}}</textarea>
                                @error('konten')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                Status
                                <select name="active" class="form-control" required>
                                    <option value="1" {{ old('active') == '1' ? 'selected':'' }}>Publish</option>
                                    <option value="0" {{ old('active') == '0' ? 'selected':'' }}>Draft</option>
                                </select>
                                <p class="text-danger">{{ $errors->first('active') }}</p>
                            </div>  --}}
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                        
                            <a  href="{{ route('account.ekraf.article.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </form>

                    </div>
                </div>
            </div>
            @push('scripts')
            <script>
                function validateForm() {
                  var deskripsi = document.getElementById("deskripsi").value;
                  if (deskripsi.trim() === "") {
                    alert("Deskripsi harus diisi, Jika sudah di isi silahkan Submit lagi");
                    return false;
                  }
                  return true;
                }
              </script>
        <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
      <script>
          CKEDITOR.replace('deskripsi');
      </script>
      @endpush
      @endsection