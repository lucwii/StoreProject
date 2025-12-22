<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Narudzbina;

class NarudzbinaSeeder extends Seeder
{
    public function run(): void
    {
        Narudzbina::create([
            'datum' => '2025-03-05',
            'status' => 'Poslata',
            'dobavljac_id' => 2,
            'user_id' => 1
        ]);
    }
}
