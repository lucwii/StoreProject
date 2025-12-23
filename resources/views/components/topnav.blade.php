@once
    @push('styles')
    <style>
        .topnav-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            padding: 8px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .topnav-bar { 
            background: #e9e9e9; 
            border-radius: 28px; 
            padding: 8px 16px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            gap: 8px;
            margin: 0 auto;
            max-width: fit-content;
        }
        body {
            padding-top: 70px;
        }
        .topnav-pill { 
            border-radius: 18px; 
            padding: 10px 20px; 
            background: #5f8fb1; 
            color: white; 
            font-weight: 600;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }
        .topnav-pill:hover {
            background: #4a7a9a;
            color: white;
        }
        .topnav-pill.active { 
            background: white; 
            color: #5f8fb1; 
            border: 2px solid #5f8fb1;
        }
        .topnav-pill.active:hover {
            background: white;
            color: #5f8fb1;
        }
    </style>
    @endpush
@endonce

@php
    $currentRoute = request()->route()->getName() ?? '';
    $isProdaja = str_contains($currentRoute, 'prodaja') || request()->is('prodaja*');
    $isDashboard = $currentRoute === 'dashboard' || request()->is('dashboard');
    $isZalihe = str_contains($currentRoute, 'artikal') || request()->is('artikals*');
    $isNabavka = str_contains($currentRoute, 'narudzbina') || request()->is('narudzbinas*');
    $isKupci = str_contains($currentRoute, 'kupac') || request()->is('kupacs*');
    $isDobavljaci = str_contains($currentRoute, 'dobavljac') || request()->is('dobavljacs*');
    $isIzvestaji = str_contains($currentRoute, 'izvestaj') || request()->is('izvestaji*');
    $isAdmin = auth()->check() && auth()->user()->load('uloga')->isAdmin();
@endphp

<div class="topnav-wrapper">
    <div class="container">
        <div class="topnav-bar">
        <a href="{{ route('dashboard') }}" class="topnav-pill {{ $isDashboard ? 'active' : '' }}">Home</a>
        <a href="{{ route('prodajas.create') }}" class="topnav-pill {{ $isProdaja ? 'active' : '' }}">Prodaja</a>
        <a href="{{ route('artikals.index') }}" class="topnav-pill {{ $isZalihe ? 'active' : '' }}">Zalihe</a>
        <a href="{{ route('narudzbinas.index') }}" class="topnav-pill {{ $isNabavka ? 'active' : '' }}">Nabavka</a>
        <a href="{{ route('kupacs.index') }}" class="topnav-pill {{ $isKupci ? 'active' : '' }}">Kupci</a>
        <a href="{{ route('dobavljacs.index') }}" class="topnav-pill {{ $isDobavljaci ? 'active' : '' }}">Dobavljači</a>
        @if($isAdmin)
            <a href="{{ route('izvestaji.index') }}" class="topnav-pill {{ $isIzvestaji ? 'active' : '' }}">Izveštaji</a>
        @endif
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="topnav-pill">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
</div>
