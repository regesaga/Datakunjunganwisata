<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryKulinerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Buat data dummy untuk tabel companies
        DB::table('categorykuliner')->insert([
            [
                'category_name' => 'Resto',
            ],
            [
                'category_name' => 'Rumah Makan',
            ],
            
            
            
        ]);

       
        // Tambahkan data dummy lainnya sesuai kebutuhan
    }
}
