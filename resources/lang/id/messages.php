<?php

use App\Models\InstagramToken;
use Illuminate\Support\Facades\DB;

$translations = [];

// $baseUrl = "https://graph.instagram.com/me/media?";
// $instagramToken = InstagramToken::select('access_token')->latest()->first();
// $accessToken = env('INSTAGRAM_TOKEN');
// if ($instagramToken != null) {
//     $accessToken = $instagramToken->access_token;
// }
// $params = array(
//     'fields' => implode(',', array('id', 'caption', 'permalink', 'media_url', 'media_type', 'thumbnail_url', 'is_shared_to_feed', 'username', 'timestamp')),
//     'access_token' => $accessToken,
//     'limit' => 20
// );
// $url = $baseUrl . http_build_query($params);
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($ch);
// curl_close($ch);
// $contentInstagram = json_decode($response, true);
// foreach ($contentInstagram['data'] as $key => $data){
//     // dd($data['caption']);
//     $translations['articelInstagram' . $key] = $data['caption'];
// }


$staticTranslations = [
    'articel' => 'Artikel',
    'Person' => 'Orang',
    'Night' => 'Malam',
    'Event' => 'Detail Acara',
    'supportby' => 'Di Dukung Oleh',
    'articelother' => 'Lainnya',
    'author' => 'Penulis',
    'tour' => 'Wisata',
    'accommodation' => 'Akomodasi',
    'culinary' => 'Kuliner',
    'destination' => 'destinasi',
    'touristMap' => 'Peta Wisata',
    'partner' => 'Kemitraan',
    'login' => 'Masuk',
    'language' => 'Bahasa',
    'webInstagram' => 'Instagram',
    'webTitle' => 'Sering di Kunjungi',
    'webWeather' => 'Perkiraan Cuaca BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)',
    'webWeather1' => 'Hari ini',
    'webWeather2' => 'Besok',
    'webWeather3' => 'Lusa',
    'webView' => 'Melihat',
    'webTours' => 'Semua Wisata',
    'webCulinary' => 'Semua Kuliner',
    'webAccommodations' => 'Semua Akomodasi',
    'webMostView' => 'Wisata Paling Banyak dilihat',
    'viewDetail' => 'Lihat Detail',
    'directMe' => 'Arahkan Saya',
    'category' => 'Kategori',
    'search' => 'Cari',
    'address' => 'Alamat',
    '01d' => 'cerah ',
    '01n' => 'cerah',
    '02d' => 'berawan',
    '02n' => 'berawan',
    '03d' => 'Mendung',
    '03n' => 'Mendung',
    '04d' => 'Mendung',
    '04n' => 'Mendung',
    '09d' => 'Hujan',
    '09n' => 'Hujan',
    '10d' => 'Hujan',
    '10n' => 'Hujan',
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember',
    'articel1' => 'Acara yang Luar Biasa',
    'destinasi1' => 'Cari Destinasi',
    'paketwisata' => 'Paket Wisata',
    'select' => 'Pilih',
    'sort' => 'Urutkan',
    'event' => 'Acara',
    'event1' => 'Tanggal Event Terlama',
    'event2' => 'Tanggal Event Terlama',
    'event3' => 'Nama Acara',
    'startTime' => 'Mulai Pukul',
    'all' => 'Semua',
    'type' => 'Pilih Jenis',
    'name' => 'Nama',
    'categoryacomodation' => 'Kategori',
    'categorykuliner' => 'Jenis',
    'address' => 'Alamat',
    'Facilities' => 'Fasilitas',
    'operational' => 'Jam Oprasional',
    'Free' => 'Gratis',
    'akomondasi1' => 'Kapasitas Pengunjung',
    'hp' => 'Telephone',
    'title' => 'Acara yang Luar Biasa',
    'description' => 'Berikut ini acara yang akan diselenggarakan',
    'eventStart' => 'Belum Berahkir',
    'eventEnd' => 'Sudah Berakhir',
    'priceTicket' => 'Harga Tiket',
    'MenuList' => 'Daftra Menu',
    'Reservation' => 'Reservasi',
    'RoomList' => 'Kamar yang Tersedia',
    'buyTicket' => 'Beli Tiket',
    'Reservekuliner' => 'Pesan',
    'explore' => 'Jelajahi Wisata',
    'comment' => 'Komentar',
    'reviews' => 'Ulasan',
    'updateReview' => 'Ubah Ulasan',
    'submitReview' => 'Kirim Ulasan',
    'rating' => 'Rating',
    'open' => 'Buka',
    'close' => 'Tutup',
    'information' => 'Keterangan',
    'Whatson' => 'Ada Apa Di Kuningan',
    'folow' => 'Yuk follow',
    'Findon' => 'Periksa dan rencanakan perjalanan Anda sekarang!',
    'disclaim' => 'Situs ini merupakan portal informasi pariwisata resmi Dinas Pemuda Olahraga dan Pariwisata Kabupaten Kuningan. Semua isi yang tercantum di dalam situs ini bertujuan untuk memberikan informasi dan bukan sebagai tujuan komersial. Penjualan yang ditampilkan merupakan tanda kemitraan yang akan menghubungkan Anda kepada Mitra Kami.',
    


    





];

$mergeTranslation = array_merge($translations, $staticTranslations);
return $mergeTranslation;