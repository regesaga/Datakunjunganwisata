<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SektorEkrafSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Buat data dummy untuk tabel companies
        DB::table('sektorekraf')->insert([
            [
                'sektor_name' => 'Pengembang Permainan',
            ],
            [
                'sektor_name' => 'Kriya',
            ],
            [
                'sektor_name' => 'Desain Interior',
            ],
            [
                'sektor_name' => 'Musik',
            ],
            [
                'sektor_name' => 'Seni Rupa',
            ],
            [
                'sektor_name' => 'Fesyen',
            ],
            [
                'sektor_name' => 'Kuliner',
            ],
            [
                'sektor_name' => 'Filem Animasi',
            ],
            [
                'sektor_name' => 'Foto Grafi',
            ],
            [
                'sektor_name' => 'Desain Komunikasi Visual',
            ],
            [
                'sektor_name' => 'Televisi Radio',
            ],
            [
                'sektor_name' => 'Arsitektur',
            ],
            [
                'sektor_name' => 'Periklanan',
            ],
            [
                'sektor_name' => 'Seni Pertunjukan',
            ],
            [
                'sektor_name' => 'Penerbitan',
            ],
            [
                'sektor_name' => 'Aplikasi',
            ],
            
            
        ]);

       
        // Tambahkan data dummy lainnya sesuai kebutuhan
    }
}
