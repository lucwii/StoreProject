<?php

namespace Database\Factories;

use App\Models\Dobavljac;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtikalFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'naziv' => fake()->word(),
            'opis' => fake()->text(),
            'nabavna_cena' => fake()->randomFloat(2, 0, 999999.99),
            'prodajna_cena' => fake()->randomFloat(2, 0, 999999.99),
            'kolicina_na_stanju' => fake()->numberBetween(-10000, 10000),
            'dobavljac_id' => Dobavljac::factory(),
        ];
    }
}
