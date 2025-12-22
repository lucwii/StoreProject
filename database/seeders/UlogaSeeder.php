<?php

namespace Database\Seeders;

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Uloga;

class UlogaSeeder extends Seeder
{
    public function run(): void
    {
        Uloga::create(['naziv' => 'Admin']);
        Uloga::create(['naziv' => 'Prodavac']);
    }
}


