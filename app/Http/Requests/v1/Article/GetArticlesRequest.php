<?php

namespace App\Http\Requests\v1\Article;

use Illuminate\Foundation\Http\FormRequest;

class GetArticlesRequest extends FormRequest
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
            'authors' => ['nullable','string'],
            'q' => ['nullable','string'],
            'page' => ['required','string','min:1'],
            'sources' => ['nullable','string'],
            // 'date_from' => ['nullable','sometimes','date'],
            // 'date_to' => ['nullable','sometimes','date','after_or_equal:date_from'],
        ];
    }
}
