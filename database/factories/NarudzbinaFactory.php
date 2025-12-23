<?php

namespace Database\Factories;

use App\Models\Dobavljac;
use App\Models\DobavljacUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NarudzbinaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'datum' => fake()->date(),
            'status' => fake()->word(),
            'dobavljac_id' => Dobavljac::factory(),
            'user_id' => User::factory(),
        ];
    }
}
