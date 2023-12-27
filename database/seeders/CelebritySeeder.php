<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class CelebritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Celebrity::factory()
            ->has(Movie::factory())
            ->count(10)
            ->create();
    }
}
