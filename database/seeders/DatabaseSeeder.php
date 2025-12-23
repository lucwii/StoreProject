<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UlogaSeeder::class,
            UserSeeder::class,
            KupacSeeder::class,
            DobavljacSeeder::class,
            ArtikalSeeder::class,
            ProdajaSeeder::class,
            StavkaProdajeSeeder::class,
            NarudzbinaSeeder::class,
            StavkaNarudzbineSeeder::class,
        ]);
    }
}
