<?php

namespace Modules\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'query' => ['nullable', 'string']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
