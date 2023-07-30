<?php

namespace App\Http\Requests\v1\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePreferenceRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'preferred_sources.*' => ['string'],
            'preferred_authors.*' => ['string'],
        ];
    }
}
