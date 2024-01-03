<?php

namespace Database\Seeders;

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
        $superAdmin->assignRole('Super Admin');


        // Creating Admin User
        $admin = User::create([
            'name' => 'Florent Blanchet',
            'email' => 'florent@helloce.fr',
            'password' => Hash::make('florent')
        ]);
        $admin->assignRole('Admin');

        // Creating Celebrity Manager User
        $celebrityManager = User::create([
            'name' => 'Dr Dre',
            'email' => 'dr@dre.fr',
            'password' => Hash::make('drdre')
        ]);
        $celebrityManager->assignRole('Celebrity Manager');
    }
}
