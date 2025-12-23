<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtikalUpdateRequest extends FormRequest
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
            'opis' => ['nullable', 'string'],
            'nabavna_cena' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'prodajna_cena' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'kolicina_na_stanju' => ['required', 'integer', 'min:0'],
            'dobavljac_id' => ['required', 'integer', 'exists:dobavljacs,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nabavna_cena.numeric' => 'Nabavna cena mora biti broj.',
            'nabavna_cena.min' => 'Nabavna cena mora biti veća ili jednaka 0.',
            'prodajna_cena.numeric' => 'Prodajna cena mora biti broj.',
            'prodajna_cena.min' => 'Prodajna cena mora biti veća ili jednaka 0.',
            'kolicina_na_stanju.integer' => 'Količina mora biti ceo broj.',
            'kolicina_na_stanju.min' => 'Količina mora biti veća ili jednaka 0.',
        ];
    }
}
