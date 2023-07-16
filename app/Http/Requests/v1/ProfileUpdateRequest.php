<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
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
        'name' => ['required','string','max:255'],
        'email' => ['required','email','max:255'],
        'password' => ['string','confirmed',Password::min(6)->mixedCase()->numbers()->symbols()],
        'gender' => ['string'],
        'phone' => ['string','max:15'],
        'user_image' => ['image','mimes:jpeg,png,jpg,gif'],
        'city' => ['string'],
        'state' => ['string'],
        'country' => ['string'],
        'bio' => ['string'],
        ];
    }
}
