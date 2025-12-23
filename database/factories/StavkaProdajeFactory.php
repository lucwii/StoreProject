<?php

namespace Database\Factories;

use App\Models\Artikal;
use App\Models\Prodaja;
use Illuminate\Database\Eloquent\Factories\Factory;

class StavkaProdajeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'prodaja_id' => Prodaja::factory(),
            'artikal_id' => Artikal::factory(),
            'kolicina' => fake()->numberBetween(-10000, 10000),
            'cena' => fake()->randomFloat(2, 0, 999999.99),
        ];
    }
}
