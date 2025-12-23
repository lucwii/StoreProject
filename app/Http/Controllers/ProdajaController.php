<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdajaStoreRequest;
use App\Http\Requests\ProdajaUpdateRequest;
use App\Models\Prodaja;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdajaController extends Controller
{
    public function index(Request $request): View
    {
        $prodajas = Prodaja::all();

        return view('prodaja.index', [
            'prodajas' => $prodajas,
        ]);
    }

    public function create(Request $request): View
    {
        return view('prodaja.create');
    }

    public function store(ProdajaStoreRequest $request): RedirectResponse
    {
        // kreiramo prodaju sa današnjim datumom
        $prodaja = Prodaja::create([
            'datum' => now(), // današnji datum
            'ukupan_iznos' => $request->ukupan_iznos,
            'nacin_placanja' => $request->nacin_placanja,
            'kupac_id' => $request->kupac_id,
            'user_id' => $request->user_id,
        ]);

        // dodajemo stavke prodaje
        foreach ($request->artikli as $artikal) {
            $prodaja->stavkaProdajes()->create([
                'artikal_id' => $artikal['artikal_id'],
                'kolicina' => $artikal['kolicina'],
                'cena' => $artikal['cena'],
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Prodaja je sačuvana.');
    }



    public function show(Request $request, Prodaja $prodaja): View
    {
        return view('prodaja.show', [
            'prodaja' => $prodaja,
        ]);
    }

    public function edit(Request $request, Prodaja $prodaja): View
    {
        return view('prodaja.edit', [
            'prodaja' => $prodaja,
        ]);
    }

    public function update(ProdajaUpdateRequest $request, Prodaja $prodaja): RedirectResponse
    {
        $prodaja->update($request->validated());

        $request->session()->flash('prodaja.id', $prodaja->id);

        return redirect()->route('prodajas.index');
    }

    public function destroy(Request $request, Prodaja $prodaja): RedirectResponse
    {
        $prodaja->delete();

        return redirect()->route('prodajas.index');
    }
}
