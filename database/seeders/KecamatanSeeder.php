<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Kecamatan')->insert([
            ['Kecamatan' => 'Ciawigebang', 'created_at' => now(), 'updated_at' => now()],
            ['Kecamatan' =>'Cibeureum ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cibingbin ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cidahu','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cigandamekar ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cigugur','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cilebak','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cilimus','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cimahi','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Ciniru','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Cipicung ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Ciwaru','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Darma ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Garawangi ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Hantara','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Jalaksana ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Japara','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Kadugede ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Kalimanggis','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Karangkancana ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Kramatmulya','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Kuningan ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Lebakwangi','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Luragung ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Maleber','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Mandirancan','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Nusaherang','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Pancalang ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Pasawahan ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Selajambe ','created_at'=> now(),'updated_at'=>now()],
            ['Kecamatan' =>'Sindangagung ','created_at'=> now(),'updated_at'=>now()],

        ]);
    }
}
