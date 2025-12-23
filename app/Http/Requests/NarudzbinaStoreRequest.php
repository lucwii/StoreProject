<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NarudzbinaStoreRequest extends FormRequest
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
            'status' => ['required', 'string', 'max:255'],
            'dobavljac_id' => ['required', 'integer', 'exists:dobavljacs,id'],
            'artikli' => ['required', 'array', 'min:1'],
            'artikli.*.artikal_id' => ['required', 'integer', 'exists:artikals,id'],
            'artikli.*.kolicina' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'artikli.*.kolicina.integer' => 'Količina mora biti ceo broj.',
            'artikli.*.kolicina.min' => 'Količina mora biti veća od 0.',
        ];
    }
}
