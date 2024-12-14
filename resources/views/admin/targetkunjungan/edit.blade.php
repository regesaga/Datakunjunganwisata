@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <form action="{{ route('admin.targetkunjungan.update', $hash->encodeHex($targetKunjungan->id)) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" name="tahun" value="{{ $targetKunjungan->tahun }}" class="form-control" readonly>
            </div>
        
            <div class="form-group">
                <label for="bulan">Bulan</label>
                <select name="bulan" class="form-control" readonly>
                    <option value="{{ $targetKunjungan->bulan }}">
                        {{ date('F', mktime(0, 0, 0, $targetKunjungan->bulan, 10)) }}
                    </option>
                </select>
                <input type="hidden" name="bulan" value="{{ $targetKunjungan->bulan }}">
            </div>
        
            <div class="form-group">
                <label for="target_kunjungan_wisata">Target Kunjungan Wisata</label>
                <input type="number" name="target_kunjungan_wisata" value="{{ $targetKunjungan->target_kunjungan_wisata }}" class="form-control" required>
            </div>
        
            <button type="submit" class="btn btn-primary">Update Target</button>
        </form>
    </div>
</section>
@endsection
