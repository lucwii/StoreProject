<?php

namespace Database\Seeders;

use App\Models\Prodaja;
use Illuminate\Database\Seeder;

class ProdajaSeeder extends Seeder
{
    public function run(): void
    {
        Prodaja::create([
            'datum' => '2025-03-10',
            'ukupan_iznos' => 6150,
            'nacin_placanja' => 'Gotovina',
            'kupac_id' => 1,
            'user_id' => 2,
        ]);

        Prodaja::create([
            'datum' => '2025-03-12',
            'ukupan_iznos' => 5400,
            'nacin_placanja' => 'Kartica',
            'kupac_id' => 2,
            'user_id' => 2,
        ]);
    }
}
