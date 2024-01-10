<?php

namespace Database\Seeders;

use App\Models\Movie;
use Database\Factories\CelebrityFactory;
use Illuminate\Database\Seeder;

class CelebritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CelebrityFactory::new()
            ->has(Movie::factory())
            ->count(10)
            ->create();
    }
}
