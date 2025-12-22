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
        $kupacs = Kupac::all();

        return view('kupac.index', [
            'kupacs' => $kupacs,
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
