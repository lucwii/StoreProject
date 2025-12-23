@extends('layouts.public')

@section('title', 'Dobavljači')

@push('styles')
<style>
    .page-title {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        color: #2b3b4a;
        margin: 20px 0;
    }
    .search-input {
        border-radius: 22px;
        border: 1px solid #ddd;
        padding: 10px 16px;
        background: #e9e9e9;
    }
    .btn-add {
        background: #5f8fb1;
        color: white;
        border-radius: 22px;
        padding: 10px 24px;
        font-weight: 600;
        border: none;
    }
    .btn-add:hover {
        background: #4a7a9a;
        color: white;
    }
    .btn-edit {
        background: #e9e9e9;
        color: #2b3b4a;
        border-radius: 18px;
        padding: 6px 16px;
        font-weight: 600;
        border: 1px solid #bdbdbd;
        font-size: 14px;
    }
    .btn-edit:hover {
        background: #d0d0d0;
        color: #2b3b4a;
    }
    .btn-delete {
        background: #f39c37;
        color: white;
        border-radius: 18px;
        padding: 6px 16px;
        font-weight: 600;
        border: none;
        font-size: 14px;
    }
    .btn-delete:hover {
        background: #d67f2b;
        color: white;
    }
    .suppliers-table {
        background: #e9e9e9;
        border-radius: 18px;
        padding: 20px;
        border: 2px solid #bdbdbd;
        margin-top: 20px;
    }
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
    }
    .table-container table {
        margin-bottom: 0;
    }
    .table-container th {
        background: #f5f5f5;
        font-weight: 600;
        border-bottom: 2px solid #ddd;
        padding: 12px;
        color: #2b3b4a;
    }
    .table-container td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    .table-container tbody tr:last-child td {
        border-bottom: none;
    }
    .options-cell {
        white-space: nowrap;
    }
    .options-cell .btn {
        margin-right: 8px;
    }
    .options-cell .btn:last-child {
        margin-right: 0;
    }
</style>
@endpush

@section('content')
    <x-topnav />

    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col-md-4">
                <form method="GET" action="{{ route('dobavljacs.index') }}" class="d-flex">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control search-input" 
                        placeholder="Pretražite" 
                        value="{{ $search }}"
                    >
                </form>
            </div>
            <div class="col-md-4 text-center">
                <h1 class="page-title">Dobavljači</h1>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('dobavljacs.create') }}" class="btn btn-add">Dodajte dobavljača</a>
            </div>
        </div>

        <div class="suppliers-table">
            <div class="table-container">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Kompanija</th>
                            <th>Kontakt osoba</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th>Opcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dobavljacs as $dobavljac)
                            <tr>
                                <td>{{ $dobavljac->naziv }}</td>
                                <td>{{ $dobavljac->kontakt_osoba }}</td>
                                <td>{{ $dobavljac->email }}</td>
                                <td>{{ $dobavljac->telefon }}</td>
                                <td class="options-cell">
                                    <a href="{{ route('dobavljacs.edit', $dobavljac) }}" class="btn btn-edit">Izmeni</a>
                                    <form action="{{ route('dobavljacs.destroy', $dobavljac) }}" method="POST" class="d-inline" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog dobavljača?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">Obriši</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    @if($search)
                                        Nema rezultata za pretragu "{{ $search }}"
                                    @else
                                        Nema dobavljača
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
