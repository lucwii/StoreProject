<?php

namespace Database\Factories;

use App\Models\Kupac;
use App\Models\KupacUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdajaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'datum' => fake()->date(),
            'ukupan_iznos' => fake()->randomFloat(2, 0, 99999999.99),
            'nacin_placanja' => fake()->word(),
            'kupac_id' => Kupac::factory(),
            'user_id' => User::factory(),
            'kupac_user_id' => KupacUser::factory(),
        ];
    }
}
