<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtikalStoreRequest;
use App\Http\Requests\ArtikalUpdateRequest;
use App\Models\Artikal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtikalController extends Controller
{
    public function index(Request $request): View
    {
        $query = Artikal::query();

        // Pretraga po nazivu ili opisu
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('naziv', 'like', '%' . $search . '%')
                  ->orWhere('opis', 'like', '%' . $search . '%');
            });
        }

        $artikals = $query->orderBy('naziv')->get();

        return view('artikal.index', [
            'artikals' => $artikals,
            'search' => $request->search ?? '',
        ]);
    }

    public function create(Request $request): View
    {
        return view('artikal.create');
    }

    public function store(ArtikalStoreRequest $request): RedirectResponse
    {
        $artikal = Artikal::create($request->validated());

        $request->session()->flash('artikal.id', $artikal->id);

        return redirect()->route('artikals.index');
    }

    public function show(Request $request, Artikal $artikal): View
    {
        return view('artikal.show', [
            'artikal' => $artikal,
        ]);
    }

    public function edit(Request $request, Artikal $artikal): View
    {
        return view('artikal.edit', [
            'artikal' => $artikal,
        ]);
    }

    public function update(ArtikalUpdateRequest $request, Artikal $artikal): RedirectResponse
    {
        $artikal->update($request->validated());

        $request->session()->flash('artikal.id', $artikal->id);

        return redirect()->route('artikals.index');
    }

    public function destroy(Request $request, Artikal $artikal): RedirectResponse
    {
        $artikal->delete();

        return redirect()->route('artikals.index');
    }
}
