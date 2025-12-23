<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DobavljacStoreRequest extends FormRequest
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
            'naziv' => ['required', 'string', 'max:255'],
            'kontakt_osoba' => ['required', 'string', 'max:255'],
            'telefon' => ['required', 'string', 'max:255', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'telefon.regex' => 'Telefon mora sadržati samo brojeve, +, -, razmake i zagrade.',
        ];
    }
}
