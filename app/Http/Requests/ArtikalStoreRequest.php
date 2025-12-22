<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtikalStoreRequest extends FormRequest
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
            'naziv' => ['required', 'string'],
            'opis' => ['required', 'string'],
            'nabavna_cena' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'prodajna_cena' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'kolicina_na_stanju' => ['required', 'integer'],
            'dobavljac_id' => ['required', 'integer', 'exists:Dobavljacs,id'],
        ];
    }
}
