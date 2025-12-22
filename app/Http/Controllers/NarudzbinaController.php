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
        $narudzbinas = Narudzbina::all();

        return view('narudzbina.index', [
            'narudzbinas' => $narudzbinas,
        ]);
    }

    public function create(Request $request): View
    {
        return view('narudzbina.create');
    }

    public function store(NarudzbinaStoreRequest $request): RedirectResponse
    {
        $narudzbina = Narudzbina::create($request->validated());

        $request->session()->flash('narudzbina.id', $narudzbina->id);

        return redirect()->route('narudzbinas.index');
    }

    public function show(Request $request, Narudzbina $narudzbina): View
    {
        return view('narudzbina.show', [
            'narudzbina' => $narudzbina,
        ]);
    }

    public function edit(Request $request, Narudzbina $narudzbina): View
    {
        return view('narudzbina.edit', [
            'narudzbina' => $narudzbina,
        ]);
    }

    public function update(NarudzbinaUpdateRequest $request, Narudzbina $narudzbina): RedirectResponse
    {
        $narudzbina->update($request->validated());

        $request->session()->flash('narudzbina.id', $narudzbina->id);

        return redirect()->route('narudzbinas.index');
    }

    public function destroy(Request $request, Narudzbina $narudzbina): RedirectResponse
    {
        $narudzbina->delete();

        return redirect()->route('narudzbinas.index');
    }
}
