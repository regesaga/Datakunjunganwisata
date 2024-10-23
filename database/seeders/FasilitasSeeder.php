<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            // Buat data dummy untuk tabel companies
            DB::table('fasilitas')->insert([
                [
                    'fasilitas_name' => 'Mushola',
                ],
                [
                  'fasilitas_name' => 'Toilet',
              ],
              [
                'fasilitas_name' => 'Pusat Kuliner',
            ],
            [
              'fasilitas_name' => 'Water boom',
          ],
          [
            'fasilitas_name' => 'Wahana selfie',
        ],
        [
          'fasilitas_name' => 'Kantin',
      ],
      [
        'fasilitas_name' => 'Fasilitas Sanitasi',
    ],
    [
      'fasilitas_name' => 'Ruang Bersantai',
  ],
  [
    'fasilitas_name' => 'Toko Suvenir',
],
[
  'fasilitas_name' => 'Tempat Pameran ',
],
[
  'fasilitas_name' => 'Area Berkemah',
],
[
  'fasilitas_name' => 'Tanda Petunjuk',
],
[
  'fasilitas_name' => 'Jalur Lari dan Trek',
],
[
  'fasilitas_name' => 'lapangan olahraga',
],
[
  'fasilitas_name' => 'Taman Hewan dan Konservasi Alam',
],

[
  'fasilitas_name' => 'Taman Petualangan',
],

[
  'fasilitas_name' => 'Perahu Dayung',
],

[
  'fasilitas_name' => 'Fasilitas Panjat Tebing',
],

[
  'fasilitas_name' => 'Fasilitas Skateboard dan BMX',
],

                [
  'fasilitas_name' => 'Ruang pelayanan', ],
[
  'fasilitas_name' => 'Kotak Penyimpanan', ],
[
  'fasilitas_name' => 'Area Umum Wifi', ],
[
  'fasilitas_name' => 'Kedai kopi', ],
[
  'fasilitas_name' => 'Restoran', ],
[
  'fasilitas_name' => 'Kopi Atau Teh Di Lobi', ],
[
  'fasilitas_name' => 'Tangga berjalan', ],
[
  'fasilitas_name' => 'Restoran Untuk Sarapan', ],
[
  'fasilitas_name' => 'Restoran Untuk Makan Siang', ],
[
  'fasilitas_name' => 'Restoran Untuk Makan Malam', ],
[
  'fasilitas_name' => 'Keluar terlambat', ],
[
  'fasilitas_name' => 'Check in lebih awal', ],
[
  'fasilitas_name' => 'Aksesibilitas', ],
[
  'fasilitas_name' => 'Kamar Mandi yang Dapat Diakses', ],
[
  'fasilitas_name' => 'Parkir yang Dapat Diakses', ],
[
  'fasilitas_name' => 'Jalur Perjalanan yang Dapat Diakses', ],
[
  'fasilitas_name' => 'Aksesibilitas Dalam Kamar', ],
[
  'fasilitas_name' => 'Gulung Saat Mandi', ],
[
  'fasilitas_name' => 'Papan Nama Braille Atau Dibesarkan', ],
[
  'fasilitas_name' => 'Peralatan Aksesibilitas', ],
[
  'fasilitas_name' => 'Dapat Diakses Kursi Roda', ],
[
  'fasilitas_name' => 'Akses Ramah', ],
[
  'fasilitas_name' => 'Bisnis', ],
[
  'fasilitas_name' => 'Pusat bisnis', ],
[
  'fasilitas_name' => 'Fasilitas Pertemuan', ],
[
  'fasilitas_name' => 'Stasiun Komputer', ],
[
  'fasilitas_name' => 'Layanan Kesekretariatan', ],
[
  'fasilitas_name' => 'Ruang konferensi', ],
[
  'fasilitas_name' => 'Proyektor', ],
[
  'fasilitas_name' => 'Nyonya Rumah Konferensi', ],
[
  'fasilitas_name' => 'Mesin fotokopi', ],
[
  'fasilitas_name' => 'Teater Atau Auditorium', ],
[
  'fasilitas_name' => 'Fasilitas Bisnis', ],
[
  'fasilitas_name' => 'Konektivitas', ],
[
  'fasilitas_name' => 'Biaya Tambahan Wi-Fi', ],
[
  'fasilitas_name' => 'Wi-Fi Gratis', ],
[
  'fasilitas_name' => 'Akses Internet Lan', ],
[
  'fasilitas_name' => 'Biaya Tambahan Akses Internet Lan', ],
[
  'fasilitas_name' => 'Biaya Tambahan Area Publik Wifi', ],
[
  'fasilitas_name' => 'Titik Internet', ],
[
  'fasilitas_name' => 'Ruang keluarga', ],
[
  'fasilitas_name' => 'Area merokok', ],
[
  'fasilitas_name' => 'AC', ],
[
  'fasilitas_name' => 'Kamar Bebas Rokok', ],
[
  'fasilitas_name' => 'teras', ],
[
  'fasilitas_name' => 'Perapian Di Lobi', ],
[
  'fasilitas_name' => 'Ruang dansa', ],
[
  'fasilitas_name' => 'Perjamuan', ],
[
  'fasilitas_name' => 'Penitipan pakaian', ],
[
  'fasilitas_name' => 'Pengering pakaian', ],
[
  'fasilitas_name' => 'Kamar Terhubung', ],
[
  'fasilitas_name' => 'Bebas Merokok', ],
[
  'fasilitas_name' => 'Pemanas', ],
[
  'fasilitas_name' => 'Teras Atap', ],
[
  'fasilitas_name' => 'Ruang rekreasi', ],
[
  'fasilitas_name' => 'Kolam', ],
[
  'fasilitas_name' => 'Makanan & Minuman', ],
[
  'fasilitas_name' => 'Kilang anggur', ],
[
  'fasilitas_name' => 'Bar Pantai', ],
[
  'fasilitas_name' => 'Batang', ],
[
  'fasilitas_name' => 'Klub malam', ],
[
  'fasilitas_name' => 'Bar Tepi Kolam Renang', ],
[
  'fasilitas_name' => 'Bar Makanan Ringan', ],
[
  'fasilitas_name' => 'Sarapan', ],
[
  'fasilitas_name' => 'Biaya Tambahan Sarapan', ],
[
  'fasilitas_name' => 'Tampilkan Memasak', ],
[
  'fasilitas_name' => 'AC Di Restoran', ],
[
  'fasilitas_name' => 'Kafe', ],
[
  'fasilitas_name' => 'Pub', ],
[
  'fasilitas_name' => 'Atur Menu Makan Malam', ],
[
  'fasilitas_name' => 'Sarapan dan Makan Malam', ],
[
  'fasilitas_name' => 'Makanan ringan', ],
[
  'fasilitas_name' => 'Sarapan dan Makan Siang', ],
[
  'fasilitas_name' => 'Pilihan Diet Khusus', ],
[
  'fasilitas_name' => 'Sarapan Pagi', ],
[
  'fasilitas_name' => 'Sarapan Terlambat', ],
[
  'fasilitas_name' => 'Sarapan Panas', ],
[
  'fasilitas_name' => 'Sarapan Disajikan Ke Meja', ],
[
  'fasilitas_name' => 'Sarapan siang', ],
[
  'fasilitas_name' => 'Makanan Bebas Gluten', ],
[
  'fasilitas_name' => 'Tidak Ada Alkohol yang Disajikan', ],
[
  'fasilitas_name' => 'Makanan vegetarian', ],
[
  'fasilitas_name' => 'Setengah Papan Tanpa Minuman', ],
[
  'fasilitas_name' => 'Half Board Dengan Minuman Non-Alkohol', ],
[
  'fasilitas_name' => 'Setengah Papan Dengan Minuman', ],
[
  'fasilitas_name' => 'Full Board Tanpa Minuman', ],
[
  'fasilitas_name' => 'Full Board Dengan Minuman Non-Alkohol', ],
[
  'fasilitas_name' => 'Paket Lengkap Dengan Minuman', ],
[
  'fasilitas_name' => 'Sarapan Prasmanan', ],
[
  'fasilitas_name' => 'Sarapan A La Carte', ],
[
  'fasilitas_name' => 'Sarapan ringan', ],
[
  'fasilitas_name' => 'Makan siang prasmanan', ],
[
  'fasilitas_name' => 'Makan Siang A La Carte', ],
[
  'fasilitas_name' => 'Atur Menu Makan Siang', ],
[
  'fasilitas_name' => 'Makan malam prasmanan', ],
[
  'fasilitas_name' => 'Makan Malam La Carte', ],
[
  'fasilitas_name' => 'Jamuan makan malam', ],
[
  'fasilitas_name' => 'Ruang makan ', ],
[
  'fasilitas_name' => 'Mantel mandi', ],
[
  'fasilitas_name' => 'Bak mandi', ],
[
  'fasilitas_name' => 'Meja', ],
[
  'fasilitas_name' => 'Lemari es', ],
[
  'fasilitas_name' => 'Pengering rambut', ],
[
  'fasilitas_name' => 'Di dalam ruangan aman', ],
[
  'fasilitas_name' => 'Televisi', ],
[
  'fasilitas_name' => 'Mandi', ],
[
  'fasilitas_name' => 'Pancuran dan Bak Mandi Terpisah', ],
[
  'fasilitas_name' => 'Mini-bar', ],
[
  'fasilitas_name' => 'gelombang mikro', ],
[
  'fasilitas_name' => 'Dapur kecil', ],
[
  'fasilitas_name' => 'TV kabel', ],
[
  'fasilitas_name' => 'Pemutar DVD', ],
[
  'fasilitas_name' => 'Toko hadiah', ],
[
  'fasilitas_name' => 'Toko', ],
[
  'fasilitas_name' => 'Atm Atau Perbankan', ],
[
  'fasilitas_name' => 'Salon rambut', ],
[
  'fasilitas_name' => 'Supermarket', ],
[
  'fasilitas_name' => 'Mesin cuci', ],
[
  'fasilitas_name' => 'Salon kecantikan', ],
[
  'fasilitas_name' => 'Melayani', ],
[
  'fasilitas_name' => 'Resepsionis', ],
[
  'fasilitas_name' => 'Ruang serbaguna', ],
[
  'fasilitas_name' => 'Layanan Binatu', ],
[
  'fasilitas_name' => 'Tur', ],
[
  'fasilitas_name' => 'Memiliki Meja Depan 24 Jam', ],
[
  'fasilitas_name' => 'Penyimpanan barang', ],
[
  'fasilitas_name' => 'Porter', ],
[
  'fasilitas_name' => 'Layanan Kamar dengan Jam Terbatas', ],
[
  'fasilitas_name' => 'Koran Di Lobi', ],
[
  'fasilitas_name' => 'Staf Multibahasa', ],
[
  'fasilitas_name' => 'Layanan Pernikahan', ],
[
  'fasilitas_name' => 'Check-in Ekspres', ],
[
  'fasilitas_name' => 'Check Out Ekspres', ],
[
  'fasilitas_name' => 'Penerimaan Gratis', ],
[
  'fasilitas_name' => 'Check in lebih awal', ],
[
  'fasilitas_name' => 'Keluar terlambat', ],
[
  'fasilitas_name' => 'Penukaran mata uang', ],
[
  'fasilitas_name' => 'Penjaga pintu', ],
[
  'fasilitas_name' => 'Seluler', ],
[
  'fasilitas_name' => 'Layanan medis', ],
[
  'fasilitas_name' => 'Memiliki Keamanan 24 Jam', ],
[
  'fasilitas_name' => 'Layanan Bellboy', ],
[
  'fasilitas_name' => 'Kios surat kabar', ],
[
  'fasilitas_name' => 'Olahraga & Rekreasi', ],
[
  'fasilitas_name' => 'Bilyar', ],
[
  'fasilitas_name' => 'Lapangan Tenis Luar Ruangan', ],
[
  'fasilitas_name' => 'Tenis', ],
[
  'fasilitas_name' => 'Ruang permainan', ],
[
  'fasilitas_name' => 'Lapangan golf', ],
[
  'fasilitas_name' => 'Lapangan Tenis Dalam Ruangan', ],
[
  'fasilitas_name' => 'Meja Golf', ],
[
  'fasilitas_name' => 'Perahu Pisang', ],
[
  'fasilitas_name' => 'Ski air', ],
[
  'fasilitas_name' => 'Jetski', ],
[
  'fasilitas_name' => 'Naik Papan Motor', ],
[
  'fasilitas_name' => 'Menyelam', ],
[
  'fasilitas_name' => 'selancar angin', ],
[
  'fasilitas_name' => 'Pelayaran', ],
[
  'fasilitas_name' => 'Berkano', ],
[
  'fasilitas_name' => 'Pelayaran Katamaran', ],
[
  'fasilitas_name' => 'Berperahu Pedal', ],
[
  'fasilitas_name' => 'Tenis meja', ],
[
  'fasilitas_name' => 'Labu', ],
[
  'fasilitas_name' => 'Aerobik', ],
[
  'fasilitas_name' => 'kebugaran', ],
[
  'fasilitas_name' => 'Panahan', ],
[
  'fasilitas_name' => 'Berkuda', ],
[
  'fasilitas_name' => 'Bersepeda Atau Bersepeda Gunung', ],
[
  'fasilitas_name' => 'Bola tangan', ],
[
  'fasilitas_name' => 'Bola basket', ],
[
  'fasilitas_name' => 'Bola voli', ],
[
  'fasilitas_name' => 'Voli pantai', ],
[
  'fasilitas_name' => 'Kolam Renang Atau Snooker', ],
[
  'fasilitas_name' => 'Bocce', ],
[
  'fasilitas_name' => 'Arena Bowling', ],
[
  'fasilitas_name' => 'Golf Mini', ],
[
  'fasilitas_name' => 'Golf', ],
[
  'fasilitas_name' => 'Berselancar', ],
[
  'fasilitas_name' => 'Tenis Dayung', ],
[
  'fasilitas_name' => 'Bulu tangkis', ],
[
  'fasilitas_name' => 'Panahan', ],
[
  'fasilitas_name' => 'Fasilitas Latihan Golf', ],
[
  'fasilitas_name' => 'Safari', ],
[
  'fasilitas_name' => 'Aqua Fit', ],
[
  'fasilitas_name' => 'Penangkapan ikan', ],
[
  'fasilitas_name' => 'Lapangan Olahraga', ],
[
  'fasilitas_name' => 'Olahraga Air', ],
[
  'fasilitas_name' => 'Snorkeling', ],
[
  'fasilitas_name' => 'Hal yang harus dilakukan', ],
[
  'fasilitas_name' => 'Biaya Tambahan Klub Anak', ],
[
  'fasilitas_name' => 'Biaya Tambahan Akses Taman Air', ],
[
  'fasilitas_name' => 'Pijat', ],
[
  'fasilitas_name' => 'Bak mandi air panas', ],
[
  'fasilitas_name' => 'Pusat kebugaran', ],
[
  'fasilitas_name' => 'Ruang uap', ],
[
  'fasilitas_name' => 'GYM', ],
[
  'fasilitas_name' => 'Spa', ],
[
  'fasilitas_name' => 'Kolam renang terbuka', ],
[
  'fasilitas_name' => 'Kebun', ],
[
  'fasilitas_name' => 'Klub kesehatan', ],
[
  'fasilitas_name' => 'Sauna', ],
[
  'fasilitas_name' => 'Bak Spa', ],
[
  'fasilitas_name' => 'Kolam Renang Anak', ],
[
  'fasilitas_name' => 'Cabana Kolam Renang', ],
[
  'fasilitas_name' => 'Pemanggang Barbekyu', ],
[
  'fasilitas_name' => 'Area piknik', ],
[
  'fasilitas_name' => 'Klub Anak-anak', ],
[
  'fasilitas_name' => 'Kursi Berjemur di Kolam Renang', ],
[
  'fasilitas_name' => 'Kursi Berjemur di Pantai', ],
[
  'fasilitas_name' => 'Handuk pantai', ],
[
  'fasilitas_name' => 'Payung pantai', ],
[
  'fasilitas_name' => 'Perpustakaan', ],
[
  'fasilitas_name' => 'Pantai Pribadi', ],
[
  'fasilitas_name' => 'Pantai Pribadi Terdekat', ],
[
  'fasilitas_name' => 'Pemandian Turki', ],
[
  'fasilitas_name' => 'Kolam renang dalam ruangan', ],
[
  'fasilitas_name' => 'Seluncuran air', ],
[
  'fasilitas_name' => 'Pusat Kebugaran dengan Diskon', ],
[
  'fasilitas_name' => 'Cabana Pantai', ],
[
  'fasilitas_name' => 'Marina', ],
[
  'fasilitas_name' => 'Akses Taman Air', ],
[
  'fasilitas_name' => 'Bar Renang', ],
[
  'fasilitas_name' => 'Kasino', ],
[
  'fasilitas_name' => 'Ruang TV', ],
[
  'fasilitas_name' => 'Area Bermain Anak', ],
[
  'fasilitas_name' => 'Kolam Air Tawar Dalam Ruangan', ],
[
  'fasilitas_name' => 'Kolam Air Panas Dalam Ruangan', ],
[
  'fasilitas_name' => 'Kolam Air Tawar Luar Ruangan', ],
[
  'fasilitas_name' => 'Kolam Air Asin Luar Ruangan', ],
[
  'fasilitas_name' => 'Kolam Air Panas Luar Ruangan', ],
[
  'fasilitas_name' => 'Kursi Berjemur', ],
[
  'fasilitas_name' => 'Payung', ],
[
  'fasilitas_name' => 'Program Hiburan Untuk Dewasa', ],
[
  'fasilitas_name' => 'Program Hiburan Untuk Anak-Anak', ],
[
  'fasilitas_name' => 'Beranda', ],
[
  'fasilitas_name' => 'Mandi uap', ],
[
  'fasilitas_name' => 'Karaoke', ],
[
  'fasilitas_name' => 'Kegiatan di luar ruangan', ],
[
  'fasilitas_name' => 'Angkutan', ],
[
  'fasilitas_name' => 'Antar-Jemput Kasino', ],
[
  'fasilitas_name' => 'Biaya Tambahan Antar-Jemput Kasino', ],
[
  'fasilitas_name' => 'Antar-Jemput Pesiar', ],
[
  'fasilitas_name' => 'Biaya Tambahan Antar-Jemput Kapal Pesiar', ],
[
  'fasilitas_name' => 'Biaya Tambahan Antar-Jemput Pusat Perbelanjaan', ],
[
  'fasilitas_name' => 'Antar-Jemput Taman Hiburan', ],
[
  'fasilitas_name' => 'Biaya Tambahan Antar-Jemput Taman Hiburan', ],
[
  'fasilitas_name' => 'Parkir valet', ],
[
  'fasilitas_name' => 'Biaya Tambahan Parkir Valet', ],
[
  'fasilitas_name' => 'Biaya Tambahan Antar-Jemput Bandara', ],
[
  'fasilitas_name' => 'Biaya Tambahan Tempat Parkir', ],
[
  'fasilitas_name' => 'Antar-Jemput Pusat Perbelanjaan', ],
[
  'fasilitas_name' => 'Tempat Parkir Terbatas', ],
[
  'fasilitas_name' => 'Biaya Tambahan Antar-Jemput Area', ],
[
  'fasilitas_name' => 'Antar-Jemput Pantai', ],
[
  'fasilitas_name' => 'Antar-Jemput Daerah', ],
[
  'fasilitas_name' => 'Parkir Truk Bus Rv', ],
[
  'fasilitas_name' => 'Penjemputan di Stasiun Kereta', ],
[
  'fasilitas_name' => 'Layanan Limo atau Mobil Kota', ],
[
  'fasilitas_name' => 'Penyimpanan Sepeda', ],
[
  'fasilitas_name' => 'Layanan Penyewaan Sepeda', ],
[
  'fasilitas_name' => 'Garasi', ],
[
  'fasilitas_name' => 'Sewa mobil', ],
[
  'fasilitas_name' => 'Layanan Perpindahan', ],
[
  'fasilitas_name' => 'Parkir Aman', ],
[
  'fasilitas_name' => 'Antar-Jemput Terminal Feri', ],
[
  'fasilitas_name' => 'Biaya Tambahan Antar-Jemput Terminal Feri', ],
[
  'fasilitas_name' => 'Bepergian Bersama Orang Lain', ],
[
  'fasilitas_name' => 'Mengasuh anak', ],
[
  'fasilitas_name' => 'Penitipan Anak yang Diawasi', ],
[
  'fasilitas_name' => 'Biaya Tambahan Pengasuhan Anak', ],
[
  'fasilitas_name' => 'Hewan Peliharaan Diperbolehkan', ],
[
  'fasilitas_name' => 'Pusat Penitipan Anak', ],
[
  'fasilitas_name' => 'Hewan Peliharaan Kecil Diizinkan', ],
[
  'fasilitas_name' => 'Hewan Peliharaan Besar Diizinkan', ],
[
  'fasilitas_name' => 'Kursi tinggi', ],
[
  'fasilitas_name' => 'boks bayi', ],
[
  'fasilitas_name' => 'Low Rope', ],
[
  'fasilitas_name' => 'Flying Fox', ],
  [
    'fasilitas_name' => 'Speda Gantung', ],
    [
      'fasilitas_name' => 'Berkuda', ],


        ]);
    }
}
