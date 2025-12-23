<?php

namespace Tests\Feature;

use App\Models\Uloga;
use App\Models\User;
use App\Models\Kupac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class KupciUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected User $prodavac;

    protected function setUp(): void
    {
        parent::setUp();

        // Uloga prodavca
        $uloga = Uloga::create(['naziv' => 'Prodavac']);

        // Prodavac
        $this->prodavac = User::factory()->create([
            'uloga_id' => $uloga->id,
        ]);
    }

    #[Test]
    public function prodavac_otvara_listu_kupaca(): void
    {
        $response = $this->actingAs($this->prodavac)
            ->get(route('kupacs.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function prodavac_dodaje_kupca(): void
    {
        $payload = [
            'ime' => 'Mila',
            'prezime' => 'Jovanovic',
            'telefon' => '060111222',
            'email' => 'mila@test.rs',
            'adresa' => 'Beograd',
        ];

        $response = $this->actingAs($this->prodavac)
            ->post(route('kupacs.store'), $payload);

        $response->assertStatus(302);
        $response->assertRedirect(route('kupacs.index'));

        $this->assertDatabaseHas('kupacs', [
            'ime' => 'Mila',
            'prezime' => 'Jovanovic',
            'telefon' => '060111222',
        ]);
    }

    #[Test]
    public function prodavac_azurira_postojeceg_kupca(): void
    {
        $kupac = Kupac::create([
            'ime' => 'Petar',
            'prezime' => 'Petrovic',
            'telefon' => '061999888',
            'email' => 'petar@test.rs',
            'adresa' => 'Novi Sad',
        ]);

        $payload = [
            'ime' => 'Petar',
            'prezime' => 'Petrovic',
            'telefon' => '061555444',
            'email' => 'petar.novi@test.rs',
            'adresa' => 'Novi Sad - Novo',
        ];

        $response = $this->actingAs($this->prodavac)
            ->put(route('kupacs.update', $kupac), $payload);

        $response->assertStatus(302);
        $response->assertRedirect(route('kupacs.index'));

        $this->assertDatabaseHas('kupacs', [
            'id' => $kupac->id,
            'telefon' => '061555444',
            'email' => 'petar.novi@test.rs',
        ]);
    }
}

