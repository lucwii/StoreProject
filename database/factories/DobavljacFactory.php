<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DobavljacFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'naziv' => fake()->word(),
            'kontakt_osoba' => fake()->word(),
            'telefon' => fake()->word(),
            'email' => fake()->safeEmail(),
        ];
    }
}
