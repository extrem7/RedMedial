<?php

namespace Modules\Admin\Http\Requests\Rss;

use Illuminate\Foundation\Http\FormRequest;

class SortRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order' => 'required|array',
            'order*' => 'integer'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
