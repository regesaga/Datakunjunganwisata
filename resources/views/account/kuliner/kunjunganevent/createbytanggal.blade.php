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
    
        <form action="{{ route('account.kuliner.kunjungankuliner.storewisnubytanggal') }}" method="POST">
            @csrf
        <div class="form-header">
                <h3  style="text-align: center; text-transform: uppercase;">input data Kunjungan</h3>
            <h2>{{$kuliner->namakuliner}}</h2>
            
          
            <div class="form-date">
                <label  style="text-align: center; text-transform: uppercase;" for="tanggal">Tanggal </label>
                <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" required>

            </div>
            <button  style="text-align: center; text-transform: uppercase;" type="submit" class="btn-save">Simpan Data</button>
        </div>
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
    
            <div class="col-lg-12">
                
                <input type="hidden" name="kuliner_id" value="{{ $hash->encode($kuliner->id) }}" required>
                        <div class="visitor-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="visitor-card">
                                            <strong  style="text-align: center; text-transform: uppercase;">Kunjungan Wisatawan Nusantara (WISNU)</strong>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th  style="text-align: center; text-transform: uppercase;">Kelompok Pengunjung</th>
                                                        <th  style="text-align: center; text-transform: uppercase;">Laki-laki</th>
                                                        <th  style="text-align: center; text-transform: uppercase;">Perempuan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($kelompok as $namaKelompok)
                                                    <tr>
                                                        <td  style="text-align: center; text-transform: uppercase;">{{ $namaKelompok->kelompokkunjungan_name }}</td>
                                                        <td  style="text-align: center; text-transform: uppercase;">
                                                            <input type="number" id="jumlah_laki_laki_{{ $namaKelompok->id }}" name="jumlah_laki_laki[{{ $namaKelompok->id }}]" class="form-control"  value="0"  oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')" oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                                        </td>
                                                        <td  style="text-align: center; text-transform: uppercase;">
                                                            <input type="number" id="jumlah_perempuan_{{ $namaKelompok->id }}" name="jumlah_perempuan[{{ $namaKelompok->id }}]" class="form-control"  value="0" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')" oninvalid="this.setCustomValidity('Harap masukkan angka')" required>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td  style="text-align: center; text-transform: uppercase;">Jumlah</td>
                                                        <td  style="text-align: center; text-transform: uppercase;">
                                                            <input type="text" id="total_wisnu_laki" name="total_wisnu_laki" class="form-control" value="0" readonly>
                                                        </td>
                                                        <td  style="text-align: center; text-transform: uppercase;">
                                                            <input type="text" id="total_wisnu_perempuan" name="total_wisnu_perempuan" class="form-control"   value="0" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: center; text-transform: uppercase;">Total                                                  
                                                        </td>
                                                        <td colspan="2"> <input type="text" id="total_wisnu" name="total_wisnu" class="form-control"    value="0" readonly></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="visitor-card">
                                            <strong  style="text-align: center; text-transform: uppercase;">Kunjungan Wisatawan Mancanegara (WISMAN)</strong>
                                            <table class="table table-bordered" id="wisman-table">
                                                <thead>
                                                    <tr>
                                                        <th  style="text-align: center; text-transform: uppercase;">Negara</th>
                                                        <th  style="text-align: center; text-transform: uppercase;">Laki-laki</th>
                                                        <th  style="text-align: center; text-transform: uppercase;">Perempuan</th>
                                                        <th  style="text-align: center; text-transform: uppercase;">Hapus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- <tr>
                                                        <td  style="text-align: center; text-transform: uppercase;">
                                                            <select name="wismannegara_id[]" class="form-control" required>
                                                                <option value="" disabled selected>Pilih</option>
                                                                @foreach($wismannegara as $negara)
                                                                <option value="{{ $negara->id }}">{{ $negara->wismannegara_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td  style="text-align: center; text-transform: uppercase;"><input type="number" name="jml_wisman_laki[]" class="form-control" value="0" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')"
                                                            oninvalid="this.setCustomValidity('Harap masukkan angka')" required></td>
                                                        <td  style="text-align: center; text-transform: uppercase;"><input type="number" name="jml_wisman_perempuan[]" class="form-control" value="0" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('')"
                                                            oninvalid="this.setCustomValidity('Harap masukkan angka')"  required></td>
                                                        <td  style="text-align: center; text-transform: uppercase;"><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                                                    </tr> -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4">
                                                            <button type="button" class="btn btn-primary" id="add-row">Tambah</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: center; text-transform: uppercase;">Jumlah</td>
                                                        <td  style="text-align: center; text-transform: uppercase;"><input type="text" name="jml_wismanlakilaki" id="jml_wismanlakilaki" class="form-control" value="0" readonly></td>
                                                        <td  style="text-align: center; text-transform: uppercase;"><input type="text" name="jml_wismanperempuan" id="jml_wismanperempuan" class="form-control" value="0" readonly></td>
                                                        <td  style="text-align: center; text-transform: uppercase;"><input type="text" name="total_wisman" id="total_wisman" class="form-control" value="0" readonly></td>
                                                        
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
        // Skrip untuk menghitung total otomatis berdasarkan inputan
        const kelompok = @json($kelompok);

        function hitungTotal() {
            let totalLaki = 0;
            let totalPerempuan = 0;

            kelompok.forEach(kelompok => {
                let laki = parseInt(document.getElementById('jumlah_laki_laki_' + kelompok.id).value) || 0;
                let perempuan = parseInt(document.getElementById('jumlah_perempuan_' + kelompok.id).value) || 0;
                
                totalLaki += laki;
                totalPerempuan += perempuan;
            });

            document.getElementById('total_wisnu_laki').value = totalLaki;
            document.getElementById('total_wisnu_perempuan').value = totalPerempuan;
            document.getElementById('total_wisnu').value = totalLaki + totalPerempuan;
        }

        kelompok.forEach(kelompok => {
            document.getElementById('jumlah_laki_laki_' + kelompok.id).addEventListener('input', hitungTotal);
            document.getElementById('jumlah_perempuan_' + kelompok.id).addEventListener('input', hitungTotal);
        });
    </script>
    <script>
        
        // Set tanggal dari controler
        document.addEventListener('DOMContentLoaded', function () {
            var tanggalKunjungan = "{{ $tanggal_kunjungan }}";  // Pastikan $tanggal_kunjungan dalam format 'YYYY-MM-DD'
            
            // Menetapkan nilai input tanggal_kunjungan menggunakan JavaScript
            document.getElementById('tanggal_kunjungan').value = tanggalKunjungan;
            const dateInput = document.querySelector('input[name="tanggal_kunjungan"]');
            dateInput.value = tanggalKunjungan.toISOString().split('T')[0];
        });
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
                    <td  style="text-align: center; text-transform: uppercase;">
                        <select name="wismannegara_id[]" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Negara --</option>
                            @foreach($wismannegara as $negara)
                            <option value="{{ $negara->id }}">{{ $negara->wismannegara_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td  style="text-align: center; text-transform: uppercase;"><input type="number" name="jml_wisman_laki[]" value="0" class="form-control" required></td>
                    <td  style="text-align: center; text-transform: uppercase;"><input type="number" name="jml_wisman_perempuan[]" value="0" class="form-control" required></td>
                    <td  style="text-align: center; text-transform: uppercase;"><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
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
