@extends('layouts.public')

@section('title', 'Dashboard')

@push('styles')
<style>
    .welcome-title {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        color: #2b3b4a;
        margin: 30px 0;
    }
    .welcome-title .highlight {
        color: #f39c37;
    }
    .dashboard-panel {
        background: #e9e9e9;
        border-radius: 18px;
        padding: 20px;
        border: 2px solid #bdbdbd;
        height: 100%;
    }
    .panel-title {
        font-size: 18px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 15px;
        color: #2b3b4a;
    }
    .dashboard-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
    }
    .dashboard-table table {
        margin-bottom: 0;
    }
    .dashboard-table th {
        background: #f5f5f5;
        font-weight: 600;
        border-bottom: 2px solid #ddd;
        padding: 12px;
        color: #2b3b4a;
    }
    .dashboard-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
    }
    .dashboard-table tbody tr:last-child td {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
    <x-topnav />

    <div class="container">
        <h1 class="welcome-title">
            Dobrodošli u farbaru <span class="highlight">Renova</span>
        </h1>

        <div class="row g-4">
            <!-- Sve prodaje -->
            <div class="col-md-4">
                <div class="dashboard-panel">
                    <h5 class="panel-title">Sve prodaje</h5>
                    <div class="dashboard-table">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Kupac</th>
                                    <th>Iznos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sveProdaje as $prodaja)
                                    <tr>
                                        <td>{{ $prodaja['kupac'] }}</td>
                                        <td>{{ $prodaja['iznos'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Nema prodaja</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Najverniji kupci -->
            <div class="col-md-4">
                <div class="dashboard-panel">
                    <h5 class="panel-title">Najverniji kupci</h5>
                    <div class="dashboard-table">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Kupac</th>
                                    <th>Ukupno potrošeno</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($najvernijiKupci as $kupac)
                                    <tr>
                                        <td>{{ $kupac['kupac'] }}</td>
                                        <td>{{ $kupac['ukupno_potroseno'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Nema kupaca</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Proizvodi sa niskom zalihom -->
            <div class="col-md-4">
                <div class="dashboard-panel">
                    <h5 class="panel-title">Proizvodi sa niskom zalihom</h5>
                    <div class="dashboard-table">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Artikl</th>
                                    <th>Količina</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proizvodiNiskaZaliha as $proizvod)
                                    <tr>
                                        <td>{{ $proizvod['artikl'] }}</td>
                                        <td>{{ $proizvod['kolicina'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Nema proizvoda</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
