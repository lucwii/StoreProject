<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UlogaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'naziv' => fake()->word(),
        ];
    }
}
