<?php

namespace Tests\Feature;

use App\Models\Artikal;
use App\Models\Dobavljac;
use App\Models\Kupac;
use App\Models\Uloga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdajaTest extends TestCase
{
    use RefreshDatabase;

    protected User $prodavac;

    protected Kupac $kupac;

    protected Artikal $artikal;

    protected function setUp(): void
    {
        parent::setUp();

        Uloga::create(['id' => 1, 'naziv' => 'Vlasnik']);
        Uloga::create(['id' => 2, 'naziv' => 'Prodavac']);

        $this->prodavac = User::factory()->create([
            'uloga_id' => 2,
        ]);

        $this->kupac = Kupac::create([
            'ime' => 'Nikola',
            'prezime' => 'Petrovic',
            'telefon' => '061123456',
            'email' => 'nikola@mail.rs',
            'adresa' => 'Beograd',
        ]);

        $dobavljac = Dobavljac::create([
            'naziv' => 'JUB',
            'kontakt_osoba' => 'Marko Markovic',
            'telefon' => '011222333',
            'email' => 'info@jub.rs',
        ]);

        $this->artikal = Artikal::create([
            'naziv' => 'Poludisperzija bela',
            'opis' => 'Unutrašnja boja',
            'nabavna_cena' => 800,
            'prodajna_cena' => 1200,
            'kolicina_na_stanju' => 50,
            'dobavljac_id' => $dobavljac->id,
        ]);
    }

    public function prodavac_moze_da_otvori_stranicu_za_kreiranje_prodaje(): void
    {
        $response = $this->actingAs($this->prodavac)
            ->get(route('prodajas.create'));

        $response->assertStatus(200);
        $response->assertSee('Prodaja');
    }

    public function prodavac_moze_da_kreira_prodaju(): void
    {
        $response = $this->actingAs($this->prodavac)
            ->post(route('prodajas.store'), [
                'kupac_id' => $this->kupac->id,
                'user_id' => $this->prodavac->id,
                'nacin_placanja' => 'gotovina',
                'ukupan_iznos' => 2400,
                'artikli' => [
                    [
                        'artikal_id' => $this->artikal->id,
                        'kolicina' => 2,
                        'cena' => 1200,
                    ],
                ],
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('prodajas', [
            'kupac_id' => $this->kupac->id,
            'user_id' => $this->prodavac->id,
            'nacin_placanja' => 'gotovina',
        ]);
    }

    public function prodaja_ne_moze_bez_kupca(): void
    {
        $response = $this->actingAs($this->prodavac)->post(route('prodajas.store'), [
            'kupac_id' => null,
            'nacin_placanja' => 'gotovina',
            'ukupan_iznos' => 1000,
            'artikli' => [
                [
                    'artikal_id' => $this->artikal->id,
                    'kolicina' => 1,
                    'cena' => 1000,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('kupac_id');
    }
}
