<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'unique:articles,name,' . $this->article->id . ',id'],
            'author' => ['required', 'min:3', 'string'],
            'text' => ['nullable', 'min:3', 'string'],
        ];
    }
}
