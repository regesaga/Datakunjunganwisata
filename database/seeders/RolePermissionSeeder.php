<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'wisata', 'kuliner','akomodasi','ekraf','guide'];
        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }

        $permissions = [
            'wisata_create', 'wisata_edit', 'wisata_show', 'wisata_delete', 'author-section', 'create-company', 'edit-company', 'delete-company'
        ];
        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }

        $role = Role::findByName('admin');
        $permissions = Permission::all()->pluck('name');
        foreach ($permissions as $permission) {
            $getPermission = Permission::findByName($permission);
            $role->givePermissionTo($getPermission);
        }

        $role = Role::findByName('kuliner');
        $permissions = [ 'author-section', 'create-company', 'edit-company'];
        foreach ($permissions as $permission) {
            $getPermission = Permission::findByName($permission);
            $role->givePermissionTo($getPermission);
        }
    }
}
