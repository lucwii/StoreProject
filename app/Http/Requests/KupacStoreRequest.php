<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KupacStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'ime' => ['required', 'string', 'max:255'],
            'prezime' => ['required', 'string', 'max:255'],
            'telefon' => ['required', 'string', 'max:255', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'adresa' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'telefon.regex' => 'Telefon mora sadržati samo brojeve, +, -, razmake i zagrade.',
        ];
    }
}
