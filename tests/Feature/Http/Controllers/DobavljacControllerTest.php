<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Dobavljac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DobavljacController
 */
final class DobavljacControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $dobavljacs = Dobavljac::factory()->count(3)->create();

        $response = $this->get(route('dobavljacs.index'));

        $response->assertOk();
        $response->assertViewIs('dobavljac.index');
        $response->assertViewHas('dobavljacs', $dobavljacs);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('dobavljacs.create'));

        $response->assertOk();
        $response->assertViewIs('dobavljac.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DobavljacController::class,
            'store',
            \App\Http\Requests\DobavljacStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $naziv = fake()->word();
        $kontakt_osoba = fake()->word();
        $telefon = fake()->word();
        $email = fake()->safeEmail();

        $response = $this->post(route('dobavljacs.store'), [
            'naziv' => $naziv,
            'kontakt_osoba' => $kontakt_osoba,
            'telefon' => $telefon,
            'email' => $email,
        ]);

        $dobavljacs = Dobavljac::query()
            ->where('naziv', $naziv)
            ->where('kontakt_osoba', $kontakt_osoba)
            ->where('telefon', $telefon)
            ->where('email', $email)
            ->get();
        $this->assertCount(1, $dobavljacs);
        $dobavljac = $dobavljacs->first();

        $response->assertRedirect(route('dobavljacs.index'));
        $response->assertSessionHas('dobavljac.id', $dobavljac->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $dobavljac = Dobavljac::factory()->create();

        $response = $this->get(route('dobavljacs.show', $dobavljac));

        $response->assertOk();
        $response->assertViewIs('dobavljac.show');
        $response->assertViewHas('dobavljac', $dobavljac);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $dobavljac = Dobavljac::factory()->create();

        $response = $this->get(route('dobavljacs.edit', $dobavljac));

        $response->assertOk();
        $response->assertViewIs('dobavljac.edit');
        $response->assertViewHas('dobavljac', $dobavljac);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DobavljacController::class,
            'update',
            \App\Http\Requests\DobavljacUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $dobavljac = Dobavljac::factory()->create();
        $naziv = fake()->word();
        $kontakt_osoba = fake()->word();
        $telefon = fake()->word();
        $email = fake()->safeEmail();

        $response = $this->put(route('dobavljacs.update', $dobavljac), [
            'naziv' => $naziv,
            'kontakt_osoba' => $kontakt_osoba,
            'telefon' => $telefon,
            'email' => $email,
        ]);

        $dobavljac->refresh();

        $response->assertRedirect(route('dobavljacs.index'));
        $response->assertSessionHas('dobavljac.id', $dobavljac->id);

        $this->assertEquals($naziv, $dobavljac->naziv);
        $this->assertEquals($kontakt_osoba, $dobavljac->kontakt_osoba);
        $this->assertEquals($telefon, $dobavljac->telefon);
        $this->assertEquals($email, $dobavljac->email);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $dobavljac = Dobavljac::factory()->create();

        $response = $this->delete(route('dobavljacs.destroy', $dobavljac));

        $response->assertRedirect(route('dobavljacs.index'));

        $this->assertModelMissing($dobavljac);
    }
}
