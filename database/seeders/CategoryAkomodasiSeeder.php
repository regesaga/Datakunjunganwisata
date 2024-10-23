<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryAkomodasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Buat data dummy untuk tabel companies
        DB::table('categoryakomodasi')->insert([
            [
                'category_name' => 'Hotel NON Bintang',
            ],
            [
                'category_name' => 'Hotel Bintang I',
            ],
            [
                'category_name' => 'Hotel Bintang II',
            ],
            [
                'category_name' => 'Hotel Bintang III',
            ],
            [
                'category_name' => 'Homestay',
            ],
            [
                'category_name' => 'Resort',
            ],
           
            
            
            
        ]);

       
        // Tambahkan data dummy lainnya sesuai kebutuhan
    }
}
