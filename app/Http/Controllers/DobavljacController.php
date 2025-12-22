<?php

namespace App\Http\Controllers;

use App\Http\Requests\DobavljacStoreRequest;
use App\Http\Requests\DobavljacUpdateRequest;
use App\Models\Dobavljac;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DobavljacController extends Controller
{
    public function index(Request $request): View
    {
        $dobavljacs = Dobavljac::all();

        return view('dobavljac.index', [
            'dobavljacs' => $dobavljacs,
        ]);
    }

    public function create(Request $request): View
    {
        return view('dobavljac.create');
    }

    public function store(DobavljacStoreRequest $request): RedirectResponse
    {
        $dobavljac = Dobavljac::create($request->validated());

        $request->session()->flash('dobavljac.id', $dobavljac->id);

        return redirect()->route('dobavljacs.index');
    }

    public function show(Request $request, Dobavljac $dobavljac): View
    {
        return view('dobavljac.show', [
            'dobavljac' => $dobavljac,
        ]);
    }

    public function edit(Request $request, Dobavljac $dobavljac): View
    {
        return view('dobavljac.edit', [
            'dobavljac' => $dobavljac,
        ]);
    }

    public function update(DobavljacUpdateRequest $request, Dobavljac $dobavljac): RedirectResponse
    {
        $dobavljac->update($request->validated());

        $request->session()->flash('dobavljac.id', $dobavljac->id);

        return redirect()->route('dobavljacs.index');
    }

    public function destroy(Request $request, Dobavljac $dobavljac): RedirectResponse
    {
        $dobavljac->delete();

        return redirect()->route('dobavljacs.index');
    }
}
