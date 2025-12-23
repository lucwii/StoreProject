@extends('layouts.public')

@section('title', 'Izveštaji')

@push('styles')
<style>
    .header-bar {
        background: #2b3b4a;
        color: white;
        padding: 15px 20px;
        margin: -30px -30px 30px -30px;
        border-radius: 18px 18px 0 0;
    }
    .header-bar h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }
    .page-title {
        font-size: 32px;
        font-weight: 700;
        text-align: center;
        color: #2b3b4a;
        margin: 30px 0;
    }
    .period-section {
        background: #e9e9e9;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 30px;
    }
    .period-label {
        font-weight: 600;
        color: #2b3b4a;
        margin-right: 10px;
    }
    .date-input {
        border-radius: 18px;
        border: 1px solid #ddd;
        padding: 10px 16px;
        background: white;
        margin: 0 10px;
        font-size: 16px;
    }
    .btn-show {
        background: #f39c37;
        color: white;
        border-radius: 18px;
        padding: 10px 24px;
        font-weight: 600;
        border: none;
        font-size: 16px;
        margin-left: 15px;
    }
    .btn-show:hover {
        background: #d67f2b;
        color: white;
    }
    .report-box {
        background: #e9e9e9;
        border-radius: 18px;
        padding: 40px;
        margin: 30px auto;
        max-width: 800px;
        border: 2px solid #bdbdbd;
    }
    .report-item {
        font-size: 18px;
        font-weight: 600;
        color: #2b3b4a;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #bdbdbd;
    }
    .report-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .report-label {
        display: inline-block;
        min-width: 250px;
    }
    .report-value {
        color: #5f8fb1;
        font-weight: 700;
    }
    .buttons-container {
        text-align: center;
        margin-top: 30px;
    }
    .btn-back {
        background: #f39c37;
        color: white;
        border-radius: 22px;
        padding: 12px 32px;
        font-weight: 600;
        border: none;
        font-size: 16px;
        margin-right: 15px;
    }
    .btn-back:hover {
        background: #d67f2b;
        color: white;
    }
    .btn-download {
        background: #5f8fb1;
        color: white;
        border-radius: 22px;
        padding: 12px 32px;
        font-weight: 600;
        border: none;
        font-size: 16px;
    }
    .btn-download:hover {
        background: #4a7a9a;
        color: white;
    }
</style>
@endpush

@section('content')
    <x-topnav />

    <div class="container">
        <div style="background: white; border-radius: 18px; padding: 30px; margin-top: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div class="header-bar">
                <h2>Izveštaji</h2>
            </div>

            <h1 class="page-title">Izveštaji poslovanja</h1>

            <div class="period-section">
                <form method="GET" action="{{ route('izvestaji.index') }}" class="d-flex align-items-center flex-wrap">
                    <span class="period-label">Period od:</span>
                    <input 
                        type="date" 
                        name="od_datum" 
                        class="form-control date-input" 
                        value="{{ $odDatum }}"
                        required
                    >
                    <span class="period-label">do:</span>
                    <input 
                        type="date" 
                        name="do_datum" 
                        class="form-control date-input" 
                        value="{{ $doDatum }}"
                        required
                    >
                    <button type="submit" class="btn btn-show">Prikažite</button>
                </form>
            </div>

            <div class="report-box">
                <div class="report-item">
                    <span class="report-label">Ukupan prihod:</span>
                    <span class="report-value">{{ number_format($ukupanPrihod, 2, ',', '.') }} RSD</span>
                </div>
                <div class="report-item">
                    <span class="report-label">Broj prodaja:</span>
                    <span class="report-value">{{ $brojProdaja }}</span>
                </div>
                <div class="report-item">
                    <span class="report-label">Najverniji kupac:</span>
                    <span class="report-value">{{ $najvernijiKupac ? $najvernijiKupac->ime . ' ' . $najvernijiKupac->prezime : 'Nema podataka' }}</span>
                </div>
                <div class="report-item">
                    <span class="report-label">Artikli sa niskom zalihom:</span>
                    <span class="report-value">{{ $artikliNiskaZaliha }}</span>
                </div>
                <div class="report-item">
                    <span class="report-label">Ukupna nabavka:</span>
                    <span class="report-value">{{ number_format($ukupnaNabavka, 2, ',', '.') }} RSD</span>
                </div>
            </div>

            <div class="buttons-container">
                <a href="{{ route('dashboard') }}" class="btn btn-back">Nazad na početnu</a>
                <button type="button" class="btn btn-download" onclick="window.print()">Preuzmi</button>
            </div>
        </div>
    </div>
@endsection

