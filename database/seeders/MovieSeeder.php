<?php

namespace Database\Seeders;

use Database\Factories\MovieFactory;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MovieFactory::new()
            ->withPrefix()
            ->createOne();
    }
}
