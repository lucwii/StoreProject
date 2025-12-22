<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NarudzbinaUpdateRequest extends FormRequest
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
            'status' => ['required', 'string'],
            'dobavljac_id' => ['required', 'integer', 'exists:dobavljacs,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'dobavljac_user_id' => ['required', 'integer', 'exists:dobavljac_users,id'],
        ];
    }
}
