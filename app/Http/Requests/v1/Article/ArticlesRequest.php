<?php

namespace App\Http\Requests\v1\Article;

use Illuminate\Foundation\Http\FormRequest;

class ArticlesRequest extends FormRequest
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
            'author' => ['required','string','max:255'],
            'title' => ['required','string'],
            'description' => ['required','string'],
            'category' => ['required','string'],
            'content' => ['required','string'],
            'image_url' => ['required','string'],
            'article_url' => ['required','string'],
            'source_api' => ['required','string'],
            'source_name' => ['required','string'],
            'source_id' => ['required','string'],
            'source' => ['required','string'],
            'published_at' => ['required','string','date'],
        ];
    }
}
