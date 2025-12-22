<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikal;

class ArtikalSeeder extends Seeder
{
    public function run(): void
    {
        Artikal::create([
            'naziv' => 'Dulux bela disperzija 15L',
            'opis' => 'Unutrašnja zidna boja visoke pokrivnosti',
            'nabavna_cena' => 3200,
            'prodajna_cena' => 4200,
            'kolicina_na_stanju' => 25,
            'dobavljac_id' => 1
        ]);

        Artikal::create([
            'naziv' => 'JUB Jupol Gold 15L',
            'opis' => 'Premium periva boja',
            'nabavna_cena' => 4100,
            'prodajna_cena' => 5400,
            'kolicina_na_stanju' => 18,
            'dobavljac_id' => 2
        ]);

        Artikal::create([
            'naziv' => 'Valjak za farbanje 25cm',
            'opis' => 'Profesionalni molerski valjak',
            'nabavna_cena' => 450,
            'prodajna_cena' => 750,
            'kolicina_na_stanju' => 60,
            'dobavljac_id' => 3
        ]);

        Artikal::create([
            'naziv' => 'Razređivač nitro 1L',
            'opis' => 'Razređivač za lakove i boje',
            'nabavna_cena' => 280,
            'prodajna_cena' => 450,
            'kolicina_na_stanju' => 40,
            'dobavljac_id' => 1
        ]);
    }
}
