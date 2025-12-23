<?php

namespace Tests\Feature;

use App\Models\Artikal;
use App\Models\Dobavljac;
use App\Models\Kupac;
use App\Models\Narudzbina;
use App\Models\Prodaja;
use App\Models\StavkaNarudzbine;
use App\Models\StavkaProdaje;
use App\Models\Uloga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IzvestajiUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected User $menadzer;

    protected function setUp(): void
    {
        parent::setUp();

        // Uloga menadžera
        Uloga::create(['id' => 1, 'naziv' => 'Admin']);

        // Menadžer
        $this->menadzer = User::factory()->create([
            'uloga_id' => 1,
        ]);
    }

    #[Test]
    public function menadzer_otvara_stranicu_izvestaja(): void
    {
        $response = $this->actingAs($this->menadzer)
            ->get(route('izvestaji.index'));

        $response->assertStatus(200);
        $response->assertSee('Izveštaji poslovanja');
    }

    #[Test]
    public function menadzer_gleda_izvestaj_sa_podacima_za_period(): void
    {
        // Kupac
        $kupac = Kupac::create([
            'ime' => 'Marko',
            'prezime' => 'Markovic',
            'telefon' => '060111222',
            'email' => 'marko@test.rs',
            'adresa' => 'Beograd',
        ]);

        // Dobavljač i artikal
        $dobavljac = Dobavljac::create([
            'naziv' => 'JUB',
            'kontakt_osoba' => 'Milan',
            'telefon' => '011222333',
            'email' => 'info@jub.rs',
        ]);

        $artikal = Artikal::create([
            'naziv' => 'Boja bela',
            'opis' => 'Unutrašnja',
            'nabavna_cena' => 500,
            'prodajna_cena' => 1000,
            'kolicina_na_stanju' => 3,
            'dobavljac_id' => $dobavljac->id,
        ]);

        // Prodaja u periodu
        $prodaja = Prodaja::create([
            'datum' => Carbon::now()->format('Y-m-d'),
            'ukupan_iznos' => 1500,
            'nacin_placanja' => 'Gotovina',
            'kupac_id' => $kupac->id,
            'user_id' => $this->menadzer->id,
        ]);

        StavkaProdaje::create([
            'prodaja_id' => $prodaja->id,
            'artikal_id' => $artikal->id,
            'kolicina' => 1,
            'cena' => 1500,
        ]);

        // Narudžbina u periodu
        $narudzbina = Narudzbina::create([
            'datum' => Carbon::now()->format('Y-m-d'),
            'status' => 'Naruceno',
            'dobavljac_id' => $dobavljac->id,
            'user_id' => $this->menadzer->id,
        ]);

        StavkaNarudzbine::create([
            'narudzbina_id' => $narudzbina->id,
            'artikal_id' => $artikal->id,
            'kolicina' => 4,
        ]);

        $od = Carbon::now()->subDay()->format('Y-m-d');
        $do = Carbon::now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($this->menadzer)
            ->get(route('izvestaji.index', [
                'od_datum' => $od,
                'do_datum' => $do,
            ]));

        $response->assertStatus(200);

        // Ukupan prihod 1500 -> format 1.500,00 RSD
        $response->assertSee('1.500,00 RSD');

        // Broj prodaja: 1
        $response->assertSee('Broj prodaja');

        // Najverniji kupac: Marko Markovic
        $response->assertSee('Marko Markovic');

        // Artikli sa niskom zalihom: 1 (kolicina 3 < 10)
        $response->assertSee('Artikli sa niskom zalihom');

        // Ukupna nabavka: 4 * 500 = 2.000,00 RSD
        $response->assertSee('2.000,00 RSD');
    }
}

