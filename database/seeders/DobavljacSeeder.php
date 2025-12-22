<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dobavljac;

class DobavljacSeeder extends Seeder
{
    public function run(): void
    {
        Dobavljac::create([
            'naziv' => 'Dulux Srbija',
            'kontakt_osoba' => 'Ivan Nikolić',
            'telefon' => '0112345678',
            'email' => 'prodaja@dulux.rs'
        ]);

        Dobavljac::create([
            'naziv' => 'JUB Boje',
            'kontakt_osoba' => 'Milan Ristić',
            'telefon' => '0119876543',
            'email' => 'office@jub.rs'
        ]);

        Dobavljac::create([
            'naziv' => 'MAXIMA Alati',
            'kontakt_osoba' => 'Stefan Lazić',
            'telefon' => '011556677',
            'email' => 'nabavka@maxima.rs'
        ]);
    }
}
