<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            KecamatanSeeder::class,
            FasilitasSeeder::class,
            CategoryAkomodasiSeeder::class,
            CategoryRoomSeeder::class,
            CategoryWisataSeeder::class,
            CategoryKulinerSeeder::class,
            CompanySeeder::class,
            SektorEkrafSeeder::class,
        ]);
    }
}
