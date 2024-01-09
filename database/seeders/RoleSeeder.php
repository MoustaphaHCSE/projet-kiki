<?php

namespace Database\Seeders;

use App\Enums\PermissionTo;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => RoleEnum::SUPER_ADMIN]);
        $admin = Role::create(['name' => RoleEnum::ADMIN]);
        $celebrityManager = Role::create(['name' => RoleEnum::CELEBRITY_MANAGER]);
        $user = Role::create(['name' => RoleEnum::USER]);

        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            PermissionTo::CREATE_USER,
            PermissionTo::EDIT_USER,
            PermissionTo::DELETE_USER,
            PermissionTo::CREATE_CELEBRITY,
            PermissionTo::EDIT_CELEBRITY,
            PermissionTo::DELETE_CELEBRITY,
        ]);

        $celebrityManager->givePermissionTo([
            PermissionTo::CREATE_CELEBRITY,
            PermissionTo::EDIT_CELEBRITY,
            PermissionTo::DELETE_CELEBRITY,
        ]);
    }
}
