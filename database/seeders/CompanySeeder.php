<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Buat data dummy untuk tabel companies
        DB::table('companies')->insert([
            'user_id' => 1,
            'nama' => 'Dinas Pemuda Olahraga dan Pariwisata Kabupaten Kuningan',
            'title' => 'Pemerintahan Kabupaten Kuningan',
            'ijin' => 'Sebagai Pengembang',
            'phone' => '1234567890',
            
        ]);

       
        // Tambahkan data dummy lainnya sesuai kebutuhan
    }
}
