@extends('layouts.public')

@section('title', 'Prodaja')

@push('styles')
<style>
    .page-title { 
        font-size: 32px; 
        font-weight: 800; 
        margin-top: 18px; 
        text-align: center;
    }
    .sales-card { 
        background: #e9e9e9; 
        border-radius: 26px; 
        padding: 20px; 
    }
    .sales-table { 
        background: white; 
        border-radius: 18px; 
        padding: 12px; 
    }
    .input-pill { 
        border-radius: 22px; 
        height: 38px; 
        border: 1px solid #ddd;
        padding: 8px 16px;
    }
    .btn-orange { 
        background: #f39c37; 
        border-color: #d67f2b; 
        color: white; 
        border-radius: 24px; 
        padding: 12px 32px; 
        font-weight: 700;
        border: none;
        font-size: 16px;
    }
    .btn-orange:hover {
        background: #d67f2b;
        color: white;
    }
    .main-wrap { 
        padding: 26px 14px; 
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }
    .table th {
        font-weight: 600;
        border-bottom: 2px solid #ddd;
    }
    .table td {
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    .form-select, .form-control {
        border-radius: 18px;
        border: 1px solid #ddd;
    }
</style>
@endpush

@section('content')
    <x-topnav />

    <div class="container main-wrap">
        <h1 class="page-title">Prodaja</h1>

        <div class="row mt-4">
            <div class="col-md-7">
                <div class="sales-card">
                    <h5 class="text-center fw-bold mb-3">Dodajte artikle</h5>
                    <div class="sales-table">
                        <table class="table mb-0" id="items-table">
                            <thead>
                                <tr>
                                    <th>Artikal</th>
                                    <th style="width:120px">Količina</th>
                                    <th style="width:140px">Iznos</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-select item-select" name="artikli[0][artikal_id]">
                                            <option value="">Izaberite artikal</option>
                                            @php $artikli = App\Models\Artikal::orderBy('naziv')->get(); @endphp
                                            @foreach($artikli as $art)
                                                <option value="{{ $art->id }}" data-price="{{ $art->prodajna_cena }}">{{ $art->naziv }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" value="1" class="form-control qty-input" name="artikli[0][kolicina]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line-total" readonly value="0.00">
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <button id="add-row" type="button" class="btn btn-light">Dodaj artikal</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <form action="{{ route('prodajas.store') }}" method="POST" id="sale-form">
                    @csrf

                    @php $kupci = App\Models\Kupac::orderBy('ime')->get(); @endphp
                    <div class="mb-4">
                        <label class="form-label">Izaberite kupca:</label>
                        <select name="kupac_id" class="form-select input-pill" required>
                            <option value="">Odaberite kupca</option>
                            @foreach($kupci as $k)
                                <option value="{{ $k->id }}">{{ $k->ime }} {{ $k->prezime }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Način plaćanja:</label>
                        <select name="nacin_placanja" class="form-select input-pill" required>
                            @php $nacini = ['Gotovina','Kartica','Preko računa']; @endphp
                            <option value="">Odaberite način plaćanja</option>
                            @foreach($nacini as $n)
                                <option value="{{ $n }}">{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ukupan iznos:</label>
                        <input type="text" name="ukupan_iznos" id="total-input" class="form-control input-pill" readonly value="0.00">
                    </div>

                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-orange" type="submit">Izvrši kupovinu</button>
                    </div>

                    <div id="hidden-items"></div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function(){
            let idx = 1;
            const artikliOptions = `@foreach($artikli as $art) <option value="{{ $art->id }}" data-price="{{ $art->prodajna_cena }}">{{ addslashes($art->naziv) }}</option> @endforeach`;

            function recalcLine($row){
                const qty = parseFloat($row.querySelector('.qty-input').value) || 0;
                const artSelect = $row.querySelector('.item-select');
                const price = parseFloat(artSelect?.selectedOptions[0]?.dataset?.price || 0);
                const line = (qty * price);
                $row.querySelector('.line-total').value = line.toFixed(2);
                recalcTotal();
            }

            function recalcTotal(){
                let total = 0;
                document.querySelectorAll('#items-table tbody .line-total').forEach(function(inp){ 
                    total += parseFloat(inp.value) || 0; 
                });
                document.getElementById('total-input').value = total.toFixed(2);
            }

            // when item selected, recalculate line
            document.addEventListener('change', function(e){
                if(e.target.classList.contains('item-select')){
                    const tr = e.target.closest('tr');
                    recalcLine(tr);
                }
            });

            // qty change
            document.addEventListener('input', function(e){
                if(e.target.classList.contains('qty-input')){
                    const tr = e.target.closest('tr');
                    recalcLine(tr);
                }
            });

            // add row
            document.getElementById('add-row')?.addEventListener('click', function(){
                const tbody = document.querySelector('#items-table tbody');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <select class="form-select item-select" name="artikli[${idx}][artikal_id]">
                            <option value="">-- izaberite artikal --</option>
                            ${artikliOptions}
                        </select>
                    </td>
                    <td>
                        <input type="number" min="1" value="1" class="form-control qty-input" name="artikli[${idx}][kolicina]">
                    </td>
                    <td>
                        <input type="text" class="form-control line-total" readonly value="0.00">
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
                        recalcTotal();
                    } else {
                        alert('Morate imati bar jedan red u tabeli.');
                    }
                }
            });

            // on submit, serialize visible rows into hidden inputs
            document.getElementById('sale-form').addEventListener('submit', function(e){
                const container = document.getElementById('hidden-items');
                container.innerHTML = '';
                const rows = document.querySelectorAll('#items-table tbody tr');
                let i = 0;
                rows.forEach(function(row){
                    const artSel = row.querySelector('.item-select');
                    const artId = artSel?.value || '';
                    const qty = row.querySelector('.qty-input')?.value || '';
                    const price = artSel?.selectedOptions[0]?.dataset?.price || '';
                    if(!artId) return; // skip empty
                    const fields = {
                        ['artikli['+i+'][artikal_id]']: artId,
                        ['artikli['+i+'][kolicina]']: qty,
                        ['artikli['+i+'][cena]']: price,
                    };
                    for(const name in fields){
                        const inp = document.createElement('input'); 
                        inp.type='hidden'; 
                        inp.name = name; 
                        inp.value = fields[name]; 
                        container.appendChild(inp);
                    }
                    i++;
                });
                // if no artikli selected, prevent submit
                if(i === 0){ 
                    e.preventDefault(); 
                    alert('Dodajte bar jedan artikal.'); 
                }
            });

            // initial recalc
            recalcTotal();
        })();
    </script>
    @endpush
@endsection

