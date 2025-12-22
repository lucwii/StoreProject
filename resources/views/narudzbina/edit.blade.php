@extends('layouts.public')

@section('title', 'Izmeni narudžbinu')

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
    .items-table {
        background: #e9e9e9;
        border-radius: 12px;
        padding: 15px;
        margin-top: 20px;
    }
    .items-table table {
        background: white;
        border-radius: 8px;
    }
    .btn-add-item {
        background: #e9e9e9;
        color: #2b3b4a;
        border-radius: 18px;
        padding: 8px 16px;
        font-weight: 600;
        border: 1px solid #bdbdbd;
        margin-top: 10px;
    }
</style>
@endpush

    @section('content')
    <div class="container">
        <div class="form-container">
            <h1 class="page-title">Izmeni narudžbinu</h1>

            <form action="{{ route('narudzbinas.update', $narudzbina) }}" method="POST" id="narudzbina-form">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Izmenite dobavljača:</label>
                            <select 
                                name="dobavljac_id" 
                                class="form-input @error('dobavljac_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Izaberite dobavljača</option>
                                @php $dobavljaci = App\Models\Dobavljac::orderBy('naziv')->get(); @endphp
                                @foreach($dobavljaci as $dobavljac)
                                    <option value="{{ $dobavljac->id }}" {{ old('dobavljac_id', $narudzbina->dobavljac_id) == $dobavljac->id ? 'selected' : '' }}>
                                        {{ $dobavljac->naziv }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dobavljac_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Izmenite status:</label>
                            <select 
                                name="status" 
                                class="form-input @error('status') is-invalid @enderror"
                                required
                            >
                                <option value="">Izaberite status</option>
                                <option value="Naruceno" {{ old('status', $narudzbina->status) == 'Naruceno' ? 'selected' : '' }}>Naručeno</option>
                                <option value="U toku" {{ old('status', $narudzbina->status) == 'U toku' ? 'selected' : '' }}>U toku</option>
                                <option value="Zavrseno" {{ old('status', $narudzbina->status) == 'Zavrseno' ? 'selected' : '' }}>Završeno</option>
                            </select>
                            @error('status')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-row">
                            <label class="form-label">Izmenite datum:</label>
                            <input 
                                type="date" 
                                name="datum" 
                                class="form-input @error('datum') is-invalid @enderror" 
                                value="{{ old('datum', $narudzbina->datum->format('Y-m-d')) }}"
                                required
                            >
                            @error('datum')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="items-table">
                    <h5 class="mb-3">Izmenite artikle:</h5>
                    <table class="table mb-0" id="items-table">
                        <thead>
                            <tr>
                                <th>Artikal</th>
                                <th style="width:150px">Količina</th>
                                <th style="width:60px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $artikli = App\Models\Artikal::orderBy('naziv')->get();
                                $stavke = $narudzbina->stavkaNarudzbines;
                            @endphp
                            @foreach($stavke as $index => $stavka)
                                <tr>
                                    <td>
                                        <select class="form-select item-select" name="artikli[{{ $index }}][artikal_id]" required>
                                            <option value="">-- izaberite artikal --</option>
                                            @foreach($artikli as $art)
                                                <option value="{{ $art->id }}" {{ $stavka->artikal_id == $art->id ? 'selected' : '' }}>
                                                    {{ $art->naziv }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" value="{{ $stavka->kolicina }}" class="form-control qty-input" name="artikli[{{ $index }}][kolicina]" required>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button>
                                    </td>
                                </tr>
                            @endforeach
                            @if($stavke->isEmpty())
                                <tr>
                                    <td>
                                        <select class="form-select item-select" name="artikli[0][artikal_id]" required>
                                            <option value="">-- izaberite artikal --</option>
                                            @foreach($artikli as $art)
                                                <option value="{{ $art->id }}">{{ $art->naziv }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" value="1" class="form-control qty-input" name="artikli[0][kolicina]" required>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button type="button" id="add-row" class="btn btn-add-item">Dodaj artikal</button>
                </div>

                <div id="hidden-items"></div>

                <div class="buttons-container">
                    <button type="submit" class="btn btn-submit">Sačuvaj izmene</button>
                    <a href="{{ route('narudzbinas.index') }}" class="btn btn-cancel">Odustanite</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        (function(){
            let idx = {{ $stavke->count() > 0 ? $stavke->count() : 1 }};
            const artikliOptions = `@foreach($artikli as $art) <option value="{{ $art->id }}">{{ addslashes($art->naziv) }}</option> @endforeach`;

            // add row
            document.getElementById('add-row').addEventListener('click', function(){
                const tbody = document.querySelector('#items-table tbody');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <select class="form-select item-select" name="artikli[${idx}][artikal_id]" required>
                            <option value="">-- izaberite artikal --</option>
                            ${artikliOptions}
                        </select>
                    </td>
                    <td>
                        <input type="number" min="1" value="1" class="form-control qty-input" name="artikli[${idx}][kolicina]" required>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button>
                    </td>
                `;
                tbody.appendChild(tr);
                idx++;
            });

            // remove row
            document.addEventListener('click', function(e){
                if(e.target.classList.contains('remove-row')){
                    const tr = e.target.closest('tr');
                    if(document.querySelectorAll('#items-table tbody tr').length > 1) {
                        tr.remove();
                    } else {
                        alert('Morate imati bar jedan red u tabeli.');
                    }
                }
            });

            // on submit, serialize visible rows
            document.getElementById('narudzbina-form').addEventListener('submit', function(e){
                const rows = document.querySelectorAll('#items-table tbody tr');
                let hasArtikal = false;
                rows.forEach(function(row){
                    const artSel = row.querySelector('.item-select');
                    if(artSel?.value) {
                        hasArtikal = true;
                    }
                });
                if(!hasArtikal){ 
                    e.preventDefault(); 
                    alert('Dodajte bar jedan artikal.'); 
                }
            });
        })();
    </script>
    @endpush
    @endsection
