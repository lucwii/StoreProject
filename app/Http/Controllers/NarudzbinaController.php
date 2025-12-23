<?php

namespace App\Http\Controllers;

use App\Http\Requests\NarudzbinaStoreRequest;
use App\Http\Requests\NarudzbinaUpdateRequest;
use App\Models\Narudzbina;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NarudzbinaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Narudzbina::with(['dobavljac', 'stavkaNarudzbines.artikal']);

        // Pretraga po statusu, dobavljaču ili artiklu
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('status', 'like', '%' . $search . '%')
                  ->orWhereHas('dobavljac', function($q) use ($search) {
                      $q->where('naziv', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('stavkaNarudzbines.artikal', function($q) use ($search) {
                      $q->where('naziv', 'like', '%' . $search . '%')
                        ->orWhere('opis', 'like', '%' . $search . '%');
                  });
            });
        }

        $narudzbinas = $query->orderBy('datum', 'desc')->get();

        // Priprema podataka za prikaz - prikazujemo stavke narudžbine
        $stavke = collect();
        foreach ($narudzbinas as $narudzbina) {
            foreach ($narudzbina->stavkaNarudzbines as $stavka) {
                $stavke->push([
                    'id' => $stavka->id,
                    'narudzbina_id' => $narudzbina->id,
                    'dobavljac' => $narudzbina->dobavljac->naziv ?? 'N/A',
                    'opis' => $stavka->artikal->opis ?? '-',
                    'status' => $narudzbina->status,
                    'artikal' => $stavka->artikal->naziv ?? 'N/A',
                    'kolicina' => $stavka->kolicina,
                ]);
            }
        }

        return view('narudzbina.index', [
            'stavke' => $stavke,
            'search' => $request->search ?? '',
        ]);
    }

    public function create(Request $request): View
    {
        return view('narudzbina.create');
    }

    public function store(NarudzbinaStoreRequest $request): RedirectResponse
    {
        $narudzbina = Narudzbina::create([
            'datum' => $request->datum,
            'status' => $request->status,
            'dobavljac_id' => $request->dobavljac_id,
            'user_id' => auth()->id(),
        ]);

        // Dodaj stavke narudžbine
        foreach ($request->artikli as $artikal) {
            $narudzbina->stavkaNarudzbines()->create([
                'artikal_id' => $artikal['artikal_id'],
                'kolicina' => $artikal['kolicina'],
            ]);
        }

        return redirect()->route('narudzbinas.index')->with('success', 'Narudžbina je sačuvana.');
    }

    public function show(Request $request, Narudzbina $narudzbina): View
    {
        return view('narudzbina.show', [
            'narudzbina' => $narudzbina,
        ]);
    }

    public function edit(Request $request, Narudzbina $narudzbina): View
    {
        $narudzbina->load(['stavkaNarudzbines.artikal', 'dobavljac']);
        return view('narudzbina.edit', [
            'narudzbina' => $narudzbina,
        ]);
    }

    public function update(NarudzbinaUpdateRequest $request, Narudzbina $narudzbina): RedirectResponse
    {
        $narudzbina->update([
            'datum' => $request->datum,
            'status' => $request->status,
            'dobavljac_id' => $request->dobavljac_id,
        ]);

        // Obriši stare stavke i dodaj nove
        $narudzbina->stavkaNarudzbines()->delete();
        foreach ($request->artikli as $artikal) {
            $narudzbina->stavkaNarudzbines()->create([
                'artikal_id' => $artikal['artikal_id'],
                'kolicina' => $artikal['kolicina'],
            ]);
        }

        return redirect()->route('narudzbinas.index')->with('success', 'Narudžbina je ažurirana.');
    }

    public function destroy(Request $request, Narudzbina $narudzbina): RedirectResponse
    {
        $narudzbina->delete();

        return redirect()->route('narudzbinas.index');
    }
}
