<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:news,title,',
            'thumbnail' => 'required|string|max:255',
            'short_description' => 'required|string',
            'date' => 'required|date',
            'likes' => 'required|integer',
            'page' => 'nullable|integer|min:1',
        ];
    }

}
