<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            
        'id' => ['required','string'],
        'name' => ['required','string','max:255'],
        'email' => ['required','email','unique:users,email','max:255'],
        'password' => ['string','confirmed',Password::min(6)->mixedCase()->numbers()->symbols()],
        'gender' => ['string'],
        'phone' => ['string','max:15'],
        'user_image' => ['string','image'],
        'city' => ['string'],
        'state' => ['string'],
        'country' => ['string'],
        'bio' => ['string'],
        ];
    }
}
