<?php

namespace Database\Seeders;

use App\Models\Kupac;
use Illuminate\Database\Seeder;

class KupacSeeder extends Seeder
{
    public function run(): void
    {
        Kupac::create([
            'ime' => 'Nikola',
            'prezime' => 'Petrović',
            'telefon' => '0641234567',
            'email' => 'nikola@petrovic-farbanje.rs',
            'adresa' => 'Voždovac, Beograd',
        ]);

        Kupac::create([
            'ime' => 'Jelena',
            'prezime' => 'Kovačević',
            'telefon' => '0639876543',
            'email' => 'jelena@design.rs',
            'adresa' => 'Novi Beograd',
        ]);

        Kupac::create([
            'ime' => 'Petar',
            'prezime' => 'Ilić',
            'telefon' => '065332211',
            'email' => 'petar@ilic.rs',
            'adresa' => 'Zemun',
        ]);

        Kupac::create([
            'ime' => 'Ana',
            'prezime' => 'Marković',
            'telefon' => '062998877',
            'email' => 'ana@markovic.rs',
            'adresa' => 'Mirijevo',
        ]);
    }
}
