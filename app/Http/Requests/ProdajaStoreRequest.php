<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdajaStoreRequest extends FormRequest
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
            'datum' => ['sometimes', 'date'],
            'ukupan_iznos' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'nacin_placanja' => ['required', 'string'],
            'kupac_id' => ['required', 'integer', 'exists:kupacs,id'],
            // user_id and kupac_user_id will be set server-side where applicable
        ];
    }
}
