<?php

namespace App\Http\Controllers;

use App\Http\Requests\KupacStoreRequest;
use App\Http\Requests\KupacUpdateRequest;
use App\Models\Kupac;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KupacController extends Controller
{
    public function index(Request $request): View
    {
        $query = Kupac::query();

        // Pretraga po imenu, prezimenu, emailu ili adresi
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ime', 'like', '%'.$search.'%')
                    ->orWhere('prezime', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('adresa', 'like', '%'.$search.'%')
                    ->orWhere('telefon', 'like', '%'.$search.'%');
            });
        }

        $kupacs = $query->orderBy('prezime')->orderBy('ime')->get();

        return view('kupac.index', [
            'kupacs' => $kupacs,
            'search' => $request->search ?? '',
        ]);
    }

    public function create(Request $request): View
    {
        return view('kupac.create');
    }

    public function store(KupacStoreRequest $request): RedirectResponse
    {
        $kupac = Kupac::create($request->validated());

        $request->session()->flash('kupac.id', $kupac->id);

        return redirect()->route('kupacs.index');
    }

    public function show(Request $request, Kupac $kupac): View
    {
        return view('kupac.show', [
            'kupac' => $kupac,
        ]);
    }

    public function edit(Request $request, Kupac $kupac): View
    {
        return view('kupac.edit', [
            'kupac' => $kupac,
        ]);
    }

    public function update(KupacUpdateRequest $request, Kupac $kupac): RedirectResponse
    {
        $kupac->update($request->validated());

        $request->session()->flash('kupac.id', $kupac->id);

        return redirect()->route('kupacs.index');
    }

    public function destroy(Request $request, Kupac $kupac): RedirectResponse
    {
        $kupac->delete();

        return redirect()->route('kupacs.index');
    }
}
