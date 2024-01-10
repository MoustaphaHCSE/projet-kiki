<?php

namespace Database\Seeders;

use App\Enums\PermissionTo;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            PermissionTo::CREATE_ROLE,
            PermissionTo::EDIT_ROLE,
            PermissionTo::DELETE_ROLE,
            PermissionTo::CREATE_USER,
            PermissionTo::EDIT_USER,
            PermissionTo::DELETE_USER,
            PermissionTo::CREATE_CELEBRITY,
            PermissionTo::EDIT_CELEBRITY,
            PermissionTo::DELETE_CELEBRITY,
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
