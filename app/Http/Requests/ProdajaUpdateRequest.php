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
            'ukupan_iznos' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'nacin_placanja' => ['required', 'string'],
            'kupac_id' => ['required', 'integer', 'exists:kupacs,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'kupac_user_id' => ['required', 'integer', 'exists:kupac_users,id'],
        ];
    }
}
