<?php

namespace Database\Factories;

use App\Models\Celebrity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Celebrity>
 */
class CelebrityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'description' => $this->faker->sentences(3, true),
            'image' => $this->faker->imageUrl(210, 210)
        ];
    }
}
