<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Artikal;
use App\Models\Dobavljac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ArtikalController
 */
final class ArtikalControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $artikals = Artikal::factory()->count(3)->create();

        $response = $this->get(route('artikals.index'));

        $response->assertOk();
        $response->assertViewIs('artikal.index');
        $response->assertViewHas('artikals', $artikals);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('artikals.create'));

        $response->assertOk();
        $response->assertViewIs('artikal.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ArtikalController::class,
            'store',
            \App\Http\Requests\ArtikalStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $naziv = fake()->word();
        $opis = fake()->text();
        $nabavna_cena = fake()->randomFloat(/** decimal_attributes **/);
        $prodajna_cena = fake()->randomFloat(/** decimal_attributes **/);
        $kolicina_na_stanju = fake()->numberBetween(-10000, 10000);
        $dobavljac = Dobavljac::factory()->create();

        $response = $this->post(route('artikals.store'), [
            'naziv' => $naziv,
            'opis' => $opis,
            'nabavna_cena' => $nabavna_cena,
            'prodajna_cena' => $prodajna_cena,
            'kolicina_na_stanju' => $kolicina_na_stanju,
            'dobavljac_id' => $dobavljac->id,
        ]);

        $artikals = Artikal::query()
            ->where('naziv', $naziv)
            ->where('opis', $opis)
            ->where('nabavna_cena', $nabavna_cena)
            ->where('prodajna_cena', $prodajna_cena)
            ->where('kolicina_na_stanju', $kolicina_na_stanju)
            ->where('dobavljac_id', $dobavljac->id)
            ->get();
        $this->assertCount(1, $artikals);
        $artikal = $artikals->first();

        $response->assertRedirect(route('artikals.index'));
        $response->assertSessionHas('artikal.id', $artikal->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $artikal = Artikal::factory()->create();

        $response = $this->get(route('artikals.show', $artikal));

        $response->assertOk();
        $response->assertViewIs('artikal.show');
        $response->assertViewHas('artikal', $artikal);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $artikal = Artikal::factory()->create();

        $response = $this->get(route('artikals.edit', $artikal));

        $response->assertOk();
        $response->assertViewIs('artikal.edit');
        $response->assertViewHas('artikal', $artikal);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ArtikalController::class,
            'update',
            \App\Http\Requests\ArtikalUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $artikal = Artikal::factory()->create();
        $naziv = fake()->word();
        $opis = fake()->text();
        $nabavna_cena = fake()->randomFloat(/** decimal_attributes **/);
        $prodajna_cena = fake()->randomFloat(/** decimal_attributes **/);
        $kolicina_na_stanju = fake()->numberBetween(-10000, 10000);
        $dobavljac = Dobavljac::factory()->create();

        $response = $this->put(route('artikals.update', $artikal), [
            'naziv' => $naziv,
            'opis' => $opis,
            'nabavna_cena' => $nabavna_cena,
            'prodajna_cena' => $prodajna_cena,
            'kolicina_na_stanju' => $kolicina_na_stanju,
            'dobavljac_id' => $dobavljac->id,
        ]);

        $artikal->refresh();

        $response->assertRedirect(route('artikals.index'));
        $response->assertSessionHas('artikal.id', $artikal->id);

        $this->assertEquals($naziv, $artikal->naziv);
        $this->assertEquals($opis, $artikal->opis);
        $this->assertEquals($nabavna_cena, $artikal->nabavna_cena);
        $this->assertEquals($prodajna_cena, $artikal->prodajna_cena);
        $this->assertEquals($kolicina_na_stanju, $artikal->kolicina_na_stanju);
        $this->assertEquals($dobavljac->id, $artikal->dobavljac_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $artikal = Artikal::factory()->create();

        $response = $this->delete(route('artikals.destroy', $artikal));

        $response->assertRedirect(route('artikals.index'));

        $this->assertModelMissing($artikal);
    }
}
