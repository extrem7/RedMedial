<?php

namespace Modules\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'message' => ['nullable', 'string'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
