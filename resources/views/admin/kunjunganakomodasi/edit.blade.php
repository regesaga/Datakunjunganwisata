@extends('layouts.datakunjungan.datakunjungan')
<style>
    /* CSS Styles */
    

    .form-container {
        max-width: 1000px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .form-header h3 {
        font-size: 16px;
        color: darkgrey;
        margin: 0;
    }

    .form-header h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .form-date {
        margin-right: 15px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-save {
        background-color: #8e44ad;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .visitor-section {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .visitor-card {
        flex: 1;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .visitor-card strong {
        display: block;
        margin-bottom: 15px;
        font-size: 18px;
        color: #333;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .table th {
        background-color: #eee;
        font-weight: bold;
    }

    .table input.form-control {
        width: 100%;
        padding: 5px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    tfoot td {
        font-weight: bold;
    }

    #add-row {
        width: 100%;
        font-weight: bold;
        margin-top: 10px;
        background-color: #0d212e;
        color: white;
        padding: 8px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .remove-row {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
        border-radius: 4px;
    }
</style>
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <form action="{{ route('admin.kunjunganakomodasi.update', $tanggal_kunjungan) }}" method="POST">
            @csrf
            @method('PUT')  <!-- Ganti dari PATCH ke PUT -->
            <div class="form-header">
                <h1>Edit Data Kunjungan</h1>
                <h2>{{ $akomodasi->namaakomodasi }}</h2>
                @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }} 
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        
                <div class="form-date">
                    <label for="tanggal">Tanggal:</label>
                    <input type="date" class="form-control" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $tanggal_kunjungan) }}" required>
                </div>
                <button type="submit" class="btn-save">Simpan Data</button>
            </div>
        
            <div class="col-lg-12">
                <input type="hidden" name="akomodasi_id" value="{{ $hash->encode($akomodasi->id) }}" required>
                <div class="visitor-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="visitor-card">
                                <strong>Kunjungan Wisatawan Nusantara (WISNU)</strong>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Pengunjung</th>
                                            <th>Laki-laki</th>
                                            <th>Perempuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aggregatedWisnuData as $data)
                                        <tr>
                                            <td>{{ $data['kelompok_kunjungan_name'] }}</td>
                                            <td>
                                                <input type="number" class="form-control" name="jumlah_laki_laki[{{ $data['kelompok_kunjungan_id'] }}]" 
                                                value="{{ old('jumlah_laki_laki.'.$data['kelompok_kunjungan_id'], $data['jumlah_laki_laki']) }}" 
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')" 
                                                oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="jumlah_perempuan[{{ $data['kelompok_kunjungan_id'] }}]" 
                                                value="{{ old('jumlah_perempuan.'.$data['kelompok_kunjungan_id'], $data['jumlah_perempuan']) }}" 
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')" 
                                                oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td>
                                                <input type="text" id="total_wisnu_laki" name="total_wisnu_laki" class="form-control" value="0" readonly>
                                            </td>
                                            <td>
                                                <input type="text" id="total_wisnu_perempuan" name="total_wisnu_perempuan" class="form-control" value="0" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td colspan="2"><input type="text" id="total_wisnu" name="total_wisnu" class="form-control" value="0" readonly></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="visitor-card">
                                <strong>Kunjungan Wisatawan Mancanegara (WISMAN)</strong>
                                <table class="table table-bordered" id="wisman-table">
                                    <thead>
                                        <tr>
                                            <th>Negara</th>
                                            <th>Laki-laki</th>
                                            <th>Perempuan</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aggregatedWismanData as $index => $data)
                                        <tr>
                                            <td>
                                                <select class="form-control" name="wismannegara_id[]" required>
                                                    <option value="">Pilih Negara</option>
                                                    @foreach($wismannegara as $negara)
                                                        <option value="{{ $negara->id }}" 
                                                            {{ old('wismannegara_id.'.$index, $data['wismannegara_id']) == $negara->id ? 'selected' : '' }}>
                                                            {{ $negara->wismannegara_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="jml_wisman_laki[]" class="form-control" 
                                                value="{{ old('jml_wisman_laki.'.$index, $data['jml_wisman_laki']) }}" 
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')"
                                                oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                            </td>
                                            <td>
                                                <input type="number" name="jml_wisman_perempuan[]" class="form-control" 
                                                value="{{ old('jml_wisman_perempuan.'.$index, $data['jml_wisman_perempuan']) }}" 
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')"
                                                oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                            </td>
                                            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <button type="button" class="btn btn-primary" id="add-row">Tambah</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td><input type="text" name="jml_wismanlakilaki" id="jml_wismanlakilaki" class="form-control" value="0" readonly></td>
                                            <td><input type="text" name="jml_wismanperempuan" id="jml_wismanperempuan" class="form-control" value="0" readonly></td>
                                            <td><input type="text" name="total_wisman" id="total_wisman" class="form-control" value="0" readonly></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</section>
@endsection

@section('scripts')
    <script>
        // Script to calculate total automatically based on input
        const kelompok = @json($kelompok);

        function hitungTotal() {
            let totalLaki = 0;
            let totalPerempuan = 0;

            kelompok.forEach(kelompok => {
                let laki = parseInt(document.querySelector('input[name="jumlah_laki_laki[' + kelompok.id + ']"]').value) || 0;
                let perempuan = parseInt(document.querySelector('input[name="jumlah_perempuan[' + kelompok.id + ']"]').value) || 0;
                
                totalLaki += laki;
                totalPerempuan += perempuan;
            });

            document.getElementById('total_wisnu_laki').value = totalLaki;
            document.getElementById('total_wisnu_perempuan').value = totalPerempuan;
            document.getElementById('total_wisnu').value = totalLaki + totalPerempuan;
        }

        kelompok.forEach(kelompok => {
            document.querySelector('input[name="jumlah_laki_laki[' + kelompok.id + ']"]').addEventListener('input', hitungTotal);
            document.querySelector('input[name="jumlah_perempuan[' + kelompok.id + ']"]').addEventListener('input', hitungTotal);
        });
      
    </script>
     <script>
        
        // Fungsi untuk menghitung total Wisatawan Mancanegara (WISMAN)
        function calculateWISMAN() {
            let totalLakiWISMAN = 0;
            let totalPerempuanWISMAN = 0;

            // Loop melalui semua input wisman laki-laki dan perempuan
            $('input[name="jml_wisman_laki[]"]').each(function () {
                totalLakiWISMAN += parseInt($(this).val()) || 0;
            });

            $('input[name="jml_wisman_perempuan[]"]').each(function () {
                totalPerempuanWISMAN += parseInt($(this).val()) || 0;
            });

            let totalWISMAN = totalLakiWISMAN + totalPerempuanWISMAN;
            // Update nilai pada field total
            $('#jml_wismanlakilaki').val(totalLakiWISMAN);
            $('#jml_wismanperempuan').val(totalPerempuanWISMAN);
            $('#total_wisman').val(totalWISMAN);
        }

        // Event listener untuk setiap perubahan input WISMAN
        $(document).on('input', 'input[name="jml_wisman_laki[]"], input[name="jml_wisman_perempuan[]"]', function () {
            calculateWISMAN();
        });

        // Menambah baris WISMAN
        $('#add-row').click(function () {
            let newRow = `
                <tr>
                    <td>
                        <select name="wismannegara_id[]" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Negara --</option>
                            @foreach($wismannegara as $negara)
                            <option value="{{ $negara->id }}">{{ $negara->wismannegara_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="jml_wisman_laki[]" class="form-control" required></td>
                    <td><input type="number" name="jml_wisman_perempuan[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                </tr>`;
            $('#wisman-table tbody').append(newRow);
            calculateWISMAN(); // Hitung ulang total setelah menambah baris
        });

        // Menghapus baris WISMAN
        $(document).on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            calculateWISMAN(); // Update total setelah menghapus baris
        });
    </script>
@endsection
