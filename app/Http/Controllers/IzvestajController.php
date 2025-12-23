<?php

namespace App\Http\Controllers;

use App\Models\Prodaja;
use App\Models\Narudzbina;
use App\Models\Kupac;
use App\Models\Artikal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class IzvestajController extends Controller
{
    public function index(Request $request): View
    {
        // Provera da li je korisnik admin
        if (!auth()->check()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }
        
        $user = auth()->user()->load('uloga');
        if (!$user->isAdmin()) {
            abort(403, 'Nemate pristup ovoj stranici.');
        }
        // Podrazumevani period - poslednji mesec
        $odDatum = $request->input('od_datum', Carbon::now()->subMonth()->format('Y-m-d'));
        $doDatum = $request->input('do_datum', Carbon::now()->format('Y-m-d'));

        // Ukupan prihod (suma svih prodaja u periodu)
        $ukupanPrihod = Prodaja::whereBetween('datum', [$odDatum, $doDatum])
            ->sum('ukupan_iznos');

        // Broj prodaja u periodu
        $brojProdaja = Prodaja::whereBetween('datum', [$odDatum, $doDatum])
            ->count();

        // Najverniji kupac (kupac sa najviše prodaja u periodu)
        $najvernijiKupac = Kupac::withCount(['prodajas' => function($query) use ($odDatum, $doDatum) {
            $query->whereBetween('datum', [$odDatum, $doDatum]);
        }])
        ->orderBy('prodajas_count', 'desc')
        ->first();

        // Artikli sa niskom zalihom (količina < 10)
        $artikliNiskaZaliha = Artikal::where('kolicina_na_stanju', '<', 10)->count();

        // Ukupna nabavka (suma svih narudžbina u periodu)
        // Prvo treba da izračunamo ukupan iznos narudžbina na osnovu stavki
        $ukupnaNabavka = 0;
        $narudzbine = Narudzbina::whereBetween('datum', [$odDatum, $doDatum])
            ->with('stavkaNarudzbines.artikal')
            ->get();
        
        foreach ($narudzbine as $narudzbina) {
            foreach ($narudzbina->stavkaNarudzbines as $stavka) {
                $ukupnaNabavka += $stavka->artikal->nabavna_cena * $stavka->kolicina;
            }
        }

        return view('izvestaj.index', [
            'odDatum' => $odDatum,
            'doDatum' => $doDatum,
            'ukupanPrihod' => $ukupanPrihod,
            'brojProdaja' => $brojProdaja,
            'najvernijiKupac' => $najvernijiKupac,
            'artikliNiskaZaliha' => $artikliNiskaZaliha,
            'ukupnaNabavka' => $ukupnaNabavka,
        ]);
    }
}

