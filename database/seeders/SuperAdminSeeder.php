<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Carter S-Admin',
            'email' => 'carter@admin.com',
            'password' => Hash::make('carter')
        ]);
        $superAdmin->assignRole(RoleEnum::SUPER_ADMIN);


        // Creating Admin User
        $admin = User::create([
            'name' => 'Florent Blanchet',
            'email' => 'florent@helloce.fr',
            'password' => Hash::make('florent')
        ]);
        $admin->assignRole(RoleEnum::ADMIN);

        // Creating Celebrity Manager User
        $celebrityManager = User::create([
            'name' => 'Dr Dre',
            'email' => 'dr@dre.fr',
            'password' => Hash::make('drdre')
        ]);
        $celebrityManager->assignRole(RoleEnum::CELEBRITY_MANAGER);

        // Creating User
        $user = User::create([
            'name' => 'Mr banal',
            'email' => 'mr@banal.fr',
            'password' => Hash::make('mrbanal'),
        ]);
        $user->assignRole(RoleEnum::USER);
    }
}
