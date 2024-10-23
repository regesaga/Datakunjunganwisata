<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryWisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Buat data dummy untuk tabel companies
        DB::table('categorywisata')->insert([
            [
                'category_name' => 'Wisata Alam',
            ],
            [
                'category_name' => 'Wisata Buatan',
            ],
            [
                'category_name' => 'Desa Wisata',
            ],
            [
                'category_name' => 'Wisata Budaya & Sejarah',
            ],
            [
                'category_name' => 'Wisata Museum',
            ],
            [
                'category_name' => 'Wisata Agro',
            ],
            [
                'category_name' => 'Wisata Hiburan Malam',
            ],
            
            
        ]);

       
        // Tambahkan data dummy lainnya sesuai kebutuhan
    }
}
