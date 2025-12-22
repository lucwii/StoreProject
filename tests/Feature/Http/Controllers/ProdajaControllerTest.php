<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Kupac;
use App\Models\KupacUser;
use App\Models\Prodaja;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProdajaController
 */
final class ProdajaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $prodajas = Prodaja::factory()->count(3)->create();

        $response = $this->get(route('prodajas.index'));

        $response->assertOk();
        $response->assertViewIs('prodaja.index');
        $response->assertViewHas('prodajas', $prodajas);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('prodajas.create'));

        $response->assertOk();
        $response->assertViewIs('prodaja.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProdajaController::class,
            'store',
            \App\Http\Requests\ProdajaStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $datum = Carbon::parse(fake()->date());
        $ukupan_iznos = fake()->randomFloat(/** decimal_attributes **/);
        $nacin_placanja = fake()->word();
        $kupac = Kupac::factory()->create();
        $user = User::factory()->create();
        $kupac_user = KupacUser::factory()->create();

        $response = $this->post(route('prodajas.store'), [
            'datum' => $datum->toDateString(),
            'ukupan_iznos' => $ukupan_iznos,
            'nacin_placanja' => $nacin_placanja,
            'kupac_id' => $kupac->id,
            'user_id' => $user->id,
            'kupac_user_id' => $kupac_user->id,
        ]);

        $prodajas = Prodaja::query()
            ->where('datum', $datum)
            ->where('ukupan_iznos', $ukupan_iznos)
            ->where('nacin_placanja', $nacin_placanja)
            ->where('kupac_id', $kupac->id)
            ->where('user_id', $user->id)
            ->where('kupac_user_id', $kupac_user->id)
            ->get();
        $this->assertCount(1, $prodajas);
        $prodaja = $prodajas->first();

        $response->assertRedirect(route('prodajas.index'));
        $response->assertSessionHas('prodaja.id', $prodaja->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $prodaja = Prodaja::factory()->create();

        $response = $this->get(route('prodajas.show', $prodaja));

        $response->assertOk();
        $response->assertViewIs('prodaja.show');
        $response->assertViewHas('prodaja', $prodaja);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $prodaja = Prodaja::factory()->create();

        $response = $this->get(route('prodajas.edit', $prodaja));

        $response->assertOk();
        $response->assertViewIs('prodaja.edit');
        $response->assertViewHas('prodaja', $prodaja);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProdajaController::class,
            'update',
            \App\Http\Requests\ProdajaUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $prodaja = Prodaja::factory()->create();
        $datum = Carbon::parse(fake()->date());
        $ukupan_iznos = fake()->randomFloat(/** decimal_attributes **/);
        $nacin_placanja = fake()->word();
        $kupac = Kupac::factory()->create();
        $user = User::factory()->create();
        $kupac_user = KupacUser::factory()->create();

        $response = $this->put(route('prodajas.update', $prodaja), [
            'datum' => $datum->toDateString(),
            'ukupan_iznos' => $ukupan_iznos,
            'nacin_placanja' => $nacin_placanja,
            'kupac_id' => $kupac->id,
            'user_id' => $user->id,
            'kupac_user_id' => $kupac_user->id,
        ]);

        $prodaja->refresh();

        $response->assertRedirect(route('prodajas.index'));
        $response->assertSessionHas('prodaja.id', $prodaja->id);

        $this->assertEquals($datum, $prodaja->datum);
        $this->assertEquals($ukupan_iznos, $prodaja->ukupan_iznos);
        $this->assertEquals($nacin_placanja, $prodaja->nacin_placanja);
        $this->assertEquals($kupac->id, $prodaja->kupac_id);
        $this->assertEquals($user->id, $prodaja->user_id);
        $this->assertEquals($kupac_user->id, $prodaja->kupac_user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $prodaja = Prodaja::factory()->create();

        $response = $this->delete(route('prodajas.destroy', $prodaja));

        $response->assertRedirect(route('prodajas.index'));

        $this->assertModelMissing($prodaja);
    }
}
