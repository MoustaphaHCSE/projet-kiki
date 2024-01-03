<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $celebrityManager = Role::create(['name' => 'Celebrity Manager']);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'create-celebrity',
            'edit-celebrity',
            'delete-celebrity'
        ]);

        $celebrityManager->givePermissionTo([
            'create-celebrity',
            'edit-celebrity',
            'delete-celebrity'
        ]);
    }
}
