<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdajaStoreRequest;
use App\Http\Requests\ProdajaUpdateRequest;
use App\Models\Prodaja;
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
        $prodaja = Prodaja::create($request->validated());

        $request->session()->flash('prodaja.id', $prodaja->id);

        return redirect()->route('prodajas.index');
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
