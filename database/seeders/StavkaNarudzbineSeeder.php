<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StavkaNarudzbine;

class StavkaNarudzbineSeeder extends Seeder
{
    public function run(): void
    {
        StavkaNarudzbine::create([
            'narudzbina_id' => 1,
            'artikal_id' => 2,
            'kolicina' => 20
        ]);
    }
}
