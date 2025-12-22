<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KupacFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ime' => fake()->word(),
            'prezime' => fake()->word(),
            'telefon' => fake()->word(),
            'email' => fake()->safeEmail(),
            'adresa' => fake()->regexify('[A-Za-z0-9]{nullable}'),
        ];
    }
}
