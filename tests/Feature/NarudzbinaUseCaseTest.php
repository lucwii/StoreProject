<?php

namespace Tests\Feature;

use App\Models\Artikal;
use App\Models\Dobavljac;
use App\Models\Uloga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NarudzbinaUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected User $menadzer;

    protected Dobavljac $dobavljac;

    protected Artikal $artikal;

    protected function setUp(): void
    {
        parent::setUp();

        // Uloga menadžera / vlasnika
        Uloga::create(['id' => 1, 'naziv' => 'Admin']);

        // Menadžer
        $this->menadzer = User::factory()->create([
            'uloga_id' => 1,
        ]);

        // Dobavljač
        $this->dobavljac = Dobavljac::factory()->create();

        // Artikal sa niskom zalihom
        $this->artikal = Artikal::factory()->create([
            'kolicina_na_stanju' => 3,
            'dobavljac_id' => $this->dobavljac->id,
        ]);
    }

    #[Test]
    public function menadzer_otvara_listu_nabavki(): void
    {
        $response = $this->actingAs($this->menadzer)
            ->get(route('narudzbinas.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function menadzer_otvara_formu_za_novu_narudzbinu(): void
    {
        $response = $this->actingAs($this->menadzer)
            ->get(route('narudzbinas.create'));

        $response->assertStatus(200);
    }

    #[Test]
    public function menadzer_kreira_narudzbinu(): void
    {
        $payload = [
            'datum' => Carbon::now()->format('Y-m-d'),
            'status' => 'Naruceno',
            'dobavljac_id' => $this->dobavljac->id,
            'artikli' => [
                [
                    'artikal_id' => $this->artikal->id,
                    'kolicina' => 10,
                ],
            ],
        ];

        $response = $this->actingAs($this->menadzer)
            ->post(route('narudzbinas.store'), $payload);

        $response->assertStatus(302);
        $response->assertRedirect(route('narudzbinas.index'));

        $this->assertDatabaseHas('narudzbinas', [
            'dobavljac_id' => $this->dobavljac->id,
            'status' => 'Naruceno',
        ]);

        $this->assertDatabaseHas('stavka_narudzbines', [
            'artikal_id' => $this->artikal->id,
            'kolicina' => 10,
        ]);
    }
}
