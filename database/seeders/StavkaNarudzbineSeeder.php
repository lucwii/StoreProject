<?php

namespace Database\Seeders;

use App\Models\StavkaNarudzbine;
use Illuminate\Database\Seeder;

class StavkaNarudzbineSeeder extends Seeder
{
    public function run(): void
    {
        StavkaNarudzbine::create([
            'narudzbina_id' => 1,
            'artikal_id' => 2,
            'kolicina' => 20,
        ]);
    }
}
