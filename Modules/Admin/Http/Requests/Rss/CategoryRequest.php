<?php

namespace Modules\Admin\Http\Requests\Rss;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'slug' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'keywords' => ['required', 'array'],
            'keywords.*' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
