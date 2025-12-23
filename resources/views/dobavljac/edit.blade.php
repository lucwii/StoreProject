@extends('layouts.public')

@section('title', 'Izmeni dobavljača')

@push('styles')
<style>
    .form-container {
        background: white;
        border-radius: 18px;
        padding: 40px;
        max-width: 1200px;
        margin: 30px auto;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .page-title {
        font-size: 32px;
        font-weight: 700;
        text-align: center;
        color: #2b3b4a;
        margin-bottom: 40px;
    }
    .form-label {
        font-weight: 600;
        color: #2b3b4a;
        margin-bottom: 8px;
        display: block;
    }
    .form-input {
        border-radius: 18px;
        border: 1px solid #ddd;
        padding: 12px 16px;
        background: #e9e9e9;
        width: 100%;
        font-size: 16px;
    }
    .form-input:focus {
        outline: none;
        border-color: #5f8fb1;
        background: white;
    }
    .form-row {
        margin-bottom: 25px;
    }
    .btn-submit {
        background: #5f8fb1;
        color: white;
        border-radius: 22px;
        padding: 12px 32px;
        font-weight: 600;
        border: none;
        font-size: 16px;
        margin-right: 15px;
    }
    .btn-submit:hover {
        background: #4a7a9a;
        color: white;
    }
    .btn-cancel {
        background: #f39c37;
        color: white;
        border-radius: 22px;
        padding: 12px 32px;
        font-weight: 600;
        border: none;
        font-size: 16px;
    }
    .btn-cancel:hover {
        background: #d67f2b;
        color: white;
    }
    .buttons-container {
        text-align: center;
        margin-top: 40px;
    }
    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="form-container">
            <h1 class="page-title">Izmeni dobavljača</h1>

            <form action="{{ route('dobavljacs.update', $dobavljac) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Izmenite kompaniju:</label>
                            <input 
                                type="text" 
                                name="naziv" 
                                class="form-input @error('naziv') is-invalid @enderror" 
                                placeholder="Kompanija" 
                                value="{{ old('naziv', $dobavljac->naziv) }}"
                                required
                            >
                            @error('naziv')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Izmenite kontakt osobu:</label>
                            <input 
                                type="text" 
                                name="kontakt_osoba" 
                                class="form-input @error('kontakt_osoba') is-invalid @enderror" 
                                placeholder="Kontakt osoba" 
                                value="{{ old('kontakt_osoba', $dobavljac->kontakt_osoba) }}"
                                required
                            >
                            @error('kontakt_osoba')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Izmenite email:</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-input @error('email') is-invalid @enderror" 
                                placeholder="Email" 
                                value="{{ old('email', $dobavljac->email) }}"
                                required
                            >
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <label class="form-label">Izmenite telefon:</label>
                            <input 
                                type="text" 
                                name="telefon" 
                                class="form-input @error('telefon') is-invalid @enderror" 
                                placeholder="Telefon" 
                                value="{{ old('telefon', $dobavljac->telefon) }}"
                                required
                            >
                            @error('telefon')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="buttons-container">
                    <button type="submit" class="btn btn-submit">Sačuvaj izmene</button>
                    <a href="{{ route('dobavljacs.index') }}" class="btn btn-cancel">Odustanite</a>
                </div>
            </form>
        </div>
    </div>
@endsection
