<?php

namespace Database\Seeders;

use App\Models\StavkaProdaje;
use Illuminate\Database\Seeder;

class StavkaProdajeSeeder extends Seeder
{
    public function run(): void
    {
        StavkaProdaje::create([
            'prodaja_id' => 1,
            'artikal_id' => 1,
            'kolicina' => 1,
            'cena' => 4200,
        ]);

        StavkaProdaje::create([
            'prodaja_id' => 1,
            'artikal_id' => 3,
            'kolicina' => 3,
            'cena' => 750,
        ]);

        StavkaProdaje::create([
            'prodaja_id' => 2,
            'artikal_id' => 2,
            'kolicina' => 1,
            'cena' => 5400,
        ]);
    }
}
