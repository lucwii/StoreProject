<?php

namespace App\Http\Controllers;

use App\Models\Prodaja;
use App\Models\Kupac;
use App\Models\Artikal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Sve prodaje sa kupcem i iznosom
        $sveProdaje = Prodaja::with('kupac')
            ->orderBy('datum', 'desc')
            ->get()
            ->map(function ($prodaja) {
                return [
                    'kupac' => $prodaja->kupac ? $prodaja->kupac->ime . ' ' . $prodaja->kupac->prezime : 'N/A',
                    'iznos' => number_format($prodaja->ukupan_iznos, 2, ',', '.') . ' RSD',
                ];
            });

        // Najverniji kupci - prva tri sa najviše potrošenim novcem
        $najvernijiKupci = Kupac::with('prodajas')
            ->get()
            ->map(function ($kupac) {
                $ukupnoPotroseno = $kupac->prodajas->sum('ukupan_iznos');
                return [
                    'id' => $kupac->id,
                    'ime' => $kupac->ime . ' ' . $kupac->prezime,
                    'ukupno_potroseno' => $ukupnoPotroseno,
                ];
            })
            ->sortByDesc('ukupno_potroseno')
            ->take(3)
            ->values()
            ->map(function ($kupac) {
                return [
                    'kupac' => $kupac['ime'],
                    'ukupno_potroseno' => number_format($kupac['ukupno_potroseno'], 2, ',', '.') . ' RSD',
                ];
            });

        // Proizvodi sa niskom zalihom - prva tri sa najmanjom zalihom
        $proizvodiNiskaZaliha = Artikal::orderBy('kolicina_na_stanju', 'asc')
            ->take(3)
            ->get()
            ->map(function ($artikal) {
                return [
                    'artikl' => $artikal->naziv,
                    'kolicina' => $artikal->kolicina_na_stanju,
                ];
            });

        return view('dashboard', [
            'sveProdaje' => $sveProdaje,
            'najvernijiKupci' => $najvernijiKupci,
            'proizvodiNiskaZaliha' => $proizvodiNiskaZaliha,
        ]);
    }
}

