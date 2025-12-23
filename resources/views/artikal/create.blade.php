@extends('layouts.public')

@section('title', 'Dodaj artikal')

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
    .form-textarea {
        border-radius: 18px;
        border: 1px solid #ddd;
        padding: 12px 16px;
        background: #e9e9e9;
        width: 100%;
        min-height: 100px;
        resize: vertical;
        font-size: 16px;
        font-family: inherit;
    }
    .form-textarea:focus {
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
            <h1 class="page-title">Dodaj artikal</h1>

            <form action="{{ route('artikals.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Unesite naziv:</label>
                            <input 
                                type="text" 
                                name="naziv" 
                                class="form-input @error('naziv') is-invalid @enderror" 
                                placeholder="Naziv" 
                                value="{{ old('naziv') }}"
                                required
                            >
                            @error('naziv')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Unesite opis:</label>
                            <textarea 
                                name="opis" 
                                class="form-textarea @error('opis') is-invalid @enderror" 
                                placeholder="Opis"
                            >{{ old('opis') }}</textarea>
                            @error('opis')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Unesite nabavnu cenu:</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="nabavna_cena" 
                                class="form-input @error('nabavna_cena') is-invalid @enderror" 
                                placeholder="Nabavna cena" 
                                value="{{ old('nabavna_cena') }}"
                                required
                            >
                            @error('nabavna_cena')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <label class="form-label">Unesite prodajnu cenu:</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="prodajna_cena" 
                                class="form-input @error('prodajna_cena') is-invalid @enderror" 
                                placeholder="Prodajna cena" 
                                value="{{ old('prodajna_cena') }}"
                                required
                            >
                            @error('prodajna_cena')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-row">
                            <label class="form-label">Unesite količinu:</label>
                            <input 
                                type="number" 
                                name="kolicina_na_stanju" 
                                class="form-input @error('kolicina_na_stanju') is-invalid @enderror" 
                                placeholder="Količina" 
                                value="{{ old('kolicina_na_stanju') }}"
                                required
                            >
                            @error('kolicina_na_stanju')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <label class="form-label">Izaberite dobavljača:</label>
                            <select 
                                name="dobavljac_id" 
                                class="form-input @error('dobavljac_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Izaberite dobavljača</option>
                                @php $dobavljaci = App\Models\Dobavljac::orderBy('naziv')->get(); @endphp
                                @foreach($dobavljaci as $dobavljac)
                                    <option value="{{ $dobavljac->id }}" {{ old('dobavljac_id') == $dobavljac->id ? 'selected' : '' }}>
                                        {{ $dobavljac->naziv }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dobavljac_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="buttons-container">
                    <button type="submit" class="btn btn-submit">Dodajte artikal</button>
                    <a href="{{ route('artikals.index') }}" class="btn btn-cancel">Odustanite</a>
                </div>
            </form>
        </div>
    </div>
@endsection
