<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use Illuminate\Database\Seeder;

class CelebritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Celebrity::factory(5)->create();
    }
}
