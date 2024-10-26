@extends('layouts.datakunjungan.datakunjungan')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form method="POST" onsubmit="return submitForm();">
                <h4 class="card-title">Tambah Laporan Kunjungan <strong>{{$wisata->namawisata}}</strong></h4>
                <input type="hidden" name="wisata_id" value="{{ $wisata->id }}">
                <!-- Form Tambah Kunjungan -->
                <!-- Tanggal Kunjungan -->
                <div class="form-group">
                    <label for="tanggal_kunjunganwisata">Tanggal</label>
                    <input type="date" name="tanggal_kunjunganwisata" id="tanggal_kunjunganwisata" class="form-control" required>
                </div>
            
                <!-- Kunjungan Wisatawan Nusantara (WISNU) -->
                <div class="card mt-4">
                    <div class="card-header">
                        <strong>Kunjungan Wisatawan Nusantara (WISNU)</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kelompok Pengunjung</th>
                                    <th>Laki-laki</th>
                                    <th>Perempuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Umum</td>
                                    <td><input type="number" id="wisnu_umum_laki" name="wisnu_umum_laki" class="form-control" required></td>
                                    <td><input type="number" id="wisnu_umum_perempuan" name="wisnu_umum_perempuan" class="form-control" required></td>
                                </tr>
                                <tr>
                                    <td>Pelajar (6-18 tahun)</td>
                                    <td><input type="number" id="wisnu_pelajar_laki" name="wisnu_pelajar_laki" class="form-control" required></td>
                                    <td><input type="number" id="wisnu_pelajar_perempuan" name="wisnu_pelajar_perempuan" class="form-control" required></td>
                                </tr>
                                <tr>
                                    <td>Instansi</td>
                                    <td><input type="number" id="wisnu_instansi_laki" name="wisnu_instansi_laki" class="form-control" required></td>
                                    <td><input type="number" id="wisnu_instansi_perempuan" name="wisnu_instansi_perempuan" class="form-control" required></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Jumlah</strong></td>
                                    <td><input type="text" id="jml_wisnu_laki" name="jml_wisnu_laki" class="form-control" value="0" readonly></td>
                                    <td><input type="text" id="jml_wisnu_perempuan" name="jml_wisnu_perempuan" class="form-control" value="0" readonly></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Total Kunjungan:</strong><input type="text" id="total_wisnu" name="total_wisnu" class="form-control" value="0" readonly></td>
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
                                    <td><input type="number" name="wisman_laki[]" class="form-control" required></td>
                                    <td><input type="number" name="wisman_perempuan[]" class="form-control" required></td>
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
                                    <td><input type="text" name="jml_wisman_laki" id="jml_wisman_laki" class="form-control" value="0" readonly></td>
                                    <td><input type="text" name="jml_wisman_perempuan" id="jml_wisman_perempuan" class="form-control" value="0" readonly></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><strong>Total Kunjungan:</strong><input type="text" name="total_wisman" id="total_wisman" class="form-control" value="0" readonly></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            
                <!-- Tombol Simpan -->
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Fungsi untuk menghitung total Wisatawan Nusantara (WISNU)
        function calculateWISNU() {
            let wisnuUmumLaki = parseInt($('#wisnu_umum_laki').val()) || 0;
            let wisnuPelajarLaki = parseInt($('#wisnu_pelajar_laki').val()) || 0;
            let wisnuInstansiLaki = parseInt($('#wisnu_instansi_laki').val()) || 0;
            
            let wisnuUmumPerempuan = parseInt($('#wisnu_umum_perempuan').val()) || 0;
            let wisnuPelajarPerempuan = parseInt($('#wisnu_pelajar_perempuan').val()) || 0;
            let wisnuInstansiPerempuan = parseInt($('#wisnu_instansi_perempuan').val()) || 0;
    
            let totalLakiWISNU = wisnuUmumLaki + wisnuPelajarLaki + wisnuInstansiLaki;
            let totalPerempuanWISNU = wisnuUmumPerempuan + wisnuPelajarPerempuan + wisnuInstansiPerempuan;
            let totalWISNU = totalLakiWISNU + totalPerempuanWISNU;
    
            // Update nilai pada field total
            $('#jml_wisnu_laki').val(totalLakiWISNU);
            $('#jml_wisnu_perempuan').val(totalPerempuanWISNU);
            $('#total_wisnu').val(totalWISNU);
        }
    
        // Fungsi untuk menghitung total Wisatawan Mancanegara (WISMAN)
        function calculateWISMAN() {
            let totalLakiWISMAN = 0;
            let totalPerempuanWISMAN = 0;
    
            // Loop melalui semua input wisman laki-laki dan perempuan
            $('input[name="wisman_laki[]"]').each(function () {
                totalLakiWISMAN += parseInt($(this).val()) || 0;
            });
    
            $('input[name="wisman_perempuan[]"]').each(function () {
                totalPerempuanWISMAN += parseInt($(this).val()) || 0;
            });
    
            let totalWISMAN = totalLakiWISMAN + totalPerempuanWISMAN;
    
            // Update nilai pada field total
            $('#jml_wisman_laki').val(totalLakiWISMAN);
            $('#jml_wisman_perempuan').val(totalPerempuanWISMAN);
            $('#total_wisman').val(totalWISMAN);
        }
    
        // Event listener untuk setiap perubahan input WISNU
        $('input[name="wisnu_umum_laki"], input[name="wisnu_pelajar_laki"], input[name="wisnu_instansi_laki"], input[name="wisnu_umum_perempuan"], input[name="wisnu_pelajar_perempuan"], input[name="wisnu_instansi_perempuan"]').on('input', function () {
            calculateWISNU();
        });
    
        // Event listener untuk setiap perubahan input WISMAN
        $(document).on('input', 'input[name="wisman_laki[]"], input[name="wisman_perempuan[]"]', function () {
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
                    <td><input type="number" name="wisman_laki[]" class="form-control" required></td>
                    <td><input type="number" name="wisman_perempuan[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                </tr>`;
            $('#wisman-table tbody').append(newRow);
        });
    
        // Menghapus baris WISMAN
        $(document).on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            calculateWISMAN(); // Update total setelah menghapus baris
        });
    
       
    });
</script>
                <script>
                    function submitForm() {
                            var tanggalKunjungan = new Date($('#tanggal_kunjunganwisata').val());
                            var tanggalSekarang = new Date();
                            var batasMaksimal = new Date();
                            batasMaksimal.setDate(tanggalSekarang.getDate() + 7);
                    
                            // Set the time portion of the current date and the maximum date to 00:00:00
                            tanggalSekarang.setHours(0, 0, 0, 0);
                            batasMaksimal.setHours(0, 0, 0, 0);
                            tanggalKunjungan.setHours(0, 0, 0, 0);
                    
                            if (tanggalKunjungan.getTime() < tanggalSekarang.getTime() || tanggalKunjungan.getTime() > batasMaksimal.getTime()) {
                                alert('Tanggal kunjungan harus dipilih sebagai tanggal sekarang atau dalam 7 hari ke depan');
                                return false; // Stop form submission
                            }
                    
                            var formData = {
                                _token: '{{ csrf_token() }}',
                                wisata_id: '{{ $wisata->id }}',
                                tanggal_kunjunganwisata: $('#tanggal_kunjunganwisata').val(),
                                wisnu_umum_laki: parseInt($('#wisnu_umum_laki').val()) || 0,
                                wisnu_umum_perempuan: parseInt($('#wisnu_umum_perempuan').val()) || 0,
                                wisnu_pelajar_laki: parseInt($('#wisnu_pelajar_laki').val()) || 0,
                                wisnu_pelajar_perempuan: parseInt($('#wisnu_pelajar_perempuan').val()) || 0,
                                wisnu_instansi_laki: parseInt($('#wisnu_instansi_laki').val()) || 0,
                                wisnu_instansi_perempuan: parseInt($('#wisnu_instansi_perempuan').val()) || 0,
                                jml_wisnu_laki: parseInt($('#jml_wisnu_laki').val()) || 0,
                                jml_wisnu_perempuan: parseInt($('#jml_wisnu_perempuan').val()) || 0,
                                total_wisnu: parseInt($('#total_wisnu').val()) || 0,
                                wisman_negara: [],
                                wisman_laki: [],
                                wisman_perempuan: [],
                                jml_wisman_laki: parseInt($('#jml_wisman_laki').val()) || 0,
                                jml_wisman_perempuan: parseInt($('#jml_wisman_perempuan').val()) || 0,
                                total_wisman: parseInt($('#total_wisman').val()) || 0,
                            };
                    
                            $('#wisman-table tbody tr').each(function () {
                                var negara = $(this).find('select[name="wisman_negara[]"]').val();
                                var laki = parseInt($(this).find('input[name="wisman_laki[]"]').val()) || 0;
                                var perempuan = parseInt($(this).find('input[name="wisman_perempuan[]"]').val()) || 0;
                    
                                if (negara) {
                                    formData.wisman_negara.push(negara);
                                    formData.wisman_laki.push(laki);
                                    formData.wisman_perempuan.push(perempuan);
                                }
                            });
                    
                            $.post("{{ route('account.wisata.datakunjunganwisata.storekunjunganwisata') }}", formData)
                                    .done(function(data) {
                            if (data.status == 'error') {
                                alert(data.message);
                                })
                                .fail(function(error) {
                                    alert("Terjadi kesalahan saat menyimpan data. Silakan coba lagi.");
                                });
                    
                            return false; // Prevent form submission
                        }
            </script>
@endsection
