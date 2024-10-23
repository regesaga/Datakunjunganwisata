<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Buat data dummy untuk tabel companies
        DB::table('categoryroom')->insert([
            [
                'category_name' => 'Standard Room',
            ],
            [
                'category_name' => 'Superior Room',
            ],
            [
                'category_name' => 'Deluxe Room',
            ],
            [
                'category_name' => 'Junior Suite Room',
            ],
            [
                'category_name' => 'Suite Room',
            ],
            [
                'category_name' => 'Presidential Suite',
            ],
            [
                'category_name' => 'Single Room',
            ],
            [
                'category_name' => 'Twin Room',
            ],
            [
                'category_name' => 'Double Room',
            ],
            [
                'category_name' => 'Family Room',
            ],
            [
                'category_name' => 'Smoking Room',
            ],
           
            
            
            
        ]);

       
        // Tambahkan data dummy lainnya sesuai kebutuhan
    }
}
