<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* create admin, author and user */
        /* password for these users is password */

        $factoryUsers = [
            [
                'name' => 'admin user',
                'email' => 'admin@admin.com',
                'password' => '$2y$10$6k999SlRLYpCBaMlRxYwjeWX3fB8GsFTZjQ0KEknlka5b99qTA2s6', // password
                'role' => 'admin'
            ],

            [
                'name' => 'kuliner user',
                'email' => 'kuliner@kuliner.com',
                'password' => '$2y$10$6k999SlRLYpCBaMlRxYwjeWX3fB8GsFTZjQ0KEknlka5b99qTA2s6', // password
                'role' => 'kuliner'
            ],
            [
                'name' => 'wisata user',
                'email' => 'wisata@wisata.com',
                'password' => '$2y$10$6k999SlRLYpCBaMlRxYwjeWX3fB8GsFTZjQ0KEknlka5b99qTA2s6', // password
                'role' => 'wisata'
            ],
            [
                'name' => 'akomodasi user',
                'email' => 'akomodasi@akomodasi.com',
                'password' => '$2y$10$6k999SlRLYpCBaMlRxYwjeWX3fB8GsFTZjQ0KEknlka5b99qTA2s6', // password
                'role' => 'akomodasi'
            ],
            [
                'name' => 'ekraf user',
                'email' => 'ekraf@ekraf.com',
                'password' => '$2y$10$6k999SlRLYpCBaMlRxYwjeWX3fB8GsFTZjQ0KEknlka5b99qTA2s6', // password
                'role' => 'ekraf'
            ],

           
        ];

        foreach ($factoryUsers as $user) {
            $newUser =  User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
            ]);
            $newUser->assignRole($user['role']);
        }
    }
}
