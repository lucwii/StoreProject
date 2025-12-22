<?php

namespace Database\Factories;

use App\Models\Artikal;
use App\Models\Narudzbina;
use App\Models\NarudzbinaArtikal;
use Illuminate\Database\Eloquent\Factories\Factory;

class StavkaNarudzbineFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'narudzbina_id' => Narudzbina::factory(),
            'artikal_id' => Artikal::factory(),
            'kolicina' => fake()->numberBetween(-10000, 10000),
            'narudzbina_artikal_id' => NarudzbinaArtikal::factory(),
        ];
    }
}
