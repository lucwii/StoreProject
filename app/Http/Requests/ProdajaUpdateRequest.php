<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdajaUpdateRequest extends FormRequest
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
            'datum' => ['required', 'date'],
            'kupac_id' => ['required', 'integer', 'exists:kupacs,id'],
            'nacin_placanja' => ['required', 'string', 'max:255'],
            'ukupan_iznos' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'artikli' => ['required', 'array', 'min:1'],
            'artikli.*.artikal_id' => ['required', 'integer', 'exists:artikals,id'],
            'artikli.*.kolicina' => ['required', 'integer', 'min:1'],
            'artikli.*.cena' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'ukupan_iznos.numeric' => 'Ukupan iznos mora biti broj.',
            'ukupan_iznos.min' => 'Ukupan iznos mora biti veći ili jednak 0.',
            'artikli.*.kolicina.integer' => 'Količina mora biti ceo broj.',
            'artikli.*.kolicina.min' => 'Količina mora biti veća od 0.',
            'artikli.*.cena.numeric' => 'Cena mora biti broj.',
            'artikli.*.cena.min' => 'Cena mora biti veća ili jednaka 0.',
        ];
    }
}
