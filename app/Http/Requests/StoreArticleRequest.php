<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:articles', 'min:3'],
            'author' => ['required', 'min:3', 'string'],
            'text' => ['nullable', 'min:3', 'string'],
        ];
    }
}
