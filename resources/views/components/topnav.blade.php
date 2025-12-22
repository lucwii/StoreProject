@once
    @push('styles')
    <style>
        .topnav-bar { 
            background: #e9e9e9; 
            border-radius: 28px; 
            padding: 8px 16px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            gap: 8px;
            margin: 8px auto 0 auto;
            max-width: fit-content;
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
@endphp

<div class="container" style="margin-top: 10px;">
    <div class="topnav-bar">
        <a href="{{ route('dashboard') }}" class="topnav-pill {{ $isDashboard ? 'active' : '' }}">Home</a>
        <a href="{{ route('prodajas.create') }}" class="topnav-pill {{ $isProdaja ? 'active' : '' }}">Prodaja</a>
        <a href="#" class="topnav-pill">Zalihe</a>
        <a href="#" class="topnav-pill">Nabavka</a>
        <a href="#" class="topnav-pill">Kupci</a>
        <a href="#" class="topnav-pill">Dobavljači</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="topnav-pill">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</div>
