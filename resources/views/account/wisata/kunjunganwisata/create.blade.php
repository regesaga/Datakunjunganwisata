@extends('layouts.datakunjungan.datakunjungan')

@section('content')
<div class="container">
    <h2>Tambah Kunjungan Wisatawan Nusantara (WISNU)</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('account.wisata.kunjunganwisata.storewisnu') }}" method="POST">
        @csrf
        <input type="hidden" name="wisata_id" value="{{ $wisata->id }}">

        <div class="card mt-4">
            <div class="card-header">
                <strong>Kunjungan Wisatawan Nusantara (WISNU)</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kelompok Pengunjung</th>
                            <th>Jumlah Laki-laki</th>
                            <th>Jumlah Perempuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelompok as $namaKelompok)
                        <tr>
                            <td>{{ $namaKelompok }}</td>
                            <td>
                                <input type="number" id="jumlah_laki_laki_{{ $namaKelompok }}" name="jumlah_laki_laki[{{ $namaKelompok }}]" class="form-control" required>
                            </td>
                            <td>
                                <input type="number" id="jumlah_perempuan_{{ $namaKelompok }}" name="jumlah_perempuan[{{ $namaKelompok }}]" class="form-control" required>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Jumlah</strong></td>
                            <td>
                                <input type="text" id="total_wisnu_laki" name="total_wisnu_laki" class="form-control" value="0" readonly>
                            </td>
                            <td>
                                <input type="text" id="total_wisnu_perempuan" name="total_wisnu_perempuan" class="form-control" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Total Kunjungan:</strong>
                                <input type="text" id="total_wisnu" name="total_wisnu" class="form-control" value="0" readonly>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Kunjungan Wisatawan Mancanegara (WISMAN) -->
        <div class="card mt-4">
            <div class="card-header">
                <strong>Kunjungan Wisatawan Mancanegara (WISMAN)</strong>
            </div>
            <div class="card-body">
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
                        <tr>
                            <td>
                                <select name="wisman_negara[]" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Negara --</option>
                                    <option value="Amerika Serikat">Amerika Serikat</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Jepang">Jepang</option>
                                </select>
                            </td>
                            <td><input type="number" name="jml_wisman_laki[]" class="form-control" required></td>
                            <td><input type="number" name="jml_wisman_perempuan[]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" id="add-row">Tambah</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah</strong></td>
                            <td><input type="text" name="jml_wismanlakilaki" id="jml_wismanlakilaki" class="form-control" value="0" readonly></td>
                            <td><input type="text" name="jml_wismanperempuan" id="jml_wismanperempuan" class="form-control" value="0" readonly></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"><strong>Total Kunjungan:</strong><input type="text" name="total_wisman" id="total_wisman" class="form-control" value="0" readonly></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Skrip untuk menghitung total otomatis berdasarkan inputan
    const kelompok = @json($kelompok);

    function hitungTotal() {
        let totalLaki = 0;
        let totalPerempuan = 0;

        kelompok.forEach(kelompok => {
            let laki = parseInt(document.getElementById('jumlah_laki_laki_' + kelompok).value) || 0;
            let perempuan = parseInt(document.getElementById('jumlah_perempuan_' + kelompok).value) || 0;
            
            totalLaki += laki;
            totalPerempuan += perempuan;
        });

        document.getElementById('total_wisnu_laki').value = totalLaki;
        document.getElementById('total_wisnu_perempuan').value = totalPerempuan;
        document.getElementById('total_wisnu').value = totalLaki + totalPerempuan;
    }

    kelompok.forEach(kelompok => {
        document.getElementById('jumlah_laki_laki_' + kelompok).addEventListener('input', hitungTotal);
        document.getElementById('jumlah_perempuan_' + kelompok).addEventListener('input', hitungTotal);
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
                        <select name="wisman_negara[]" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Negara --</option>
                            <option value="Amerika Serikat">Amerika Serikat</option>
                            <option value="Australia">Australia</option>
                            <option value="Jepang">Jepang</option>
                        </select>
                    </td>
                    <td><input type="number" name="jml_wisman_laki[]" class="form-control" required></td>
                    <td><input type="number" name="jml_wisman_perempuan[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                </tr>`;
            $('#wisman-table tbody').append(newRow);
        });
    
        // Menghapus baris WISMAN
        $(document).on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            calculateWISMAN(); // Update total setelah menghapus baris
        });
        
    </script>

@endsection
