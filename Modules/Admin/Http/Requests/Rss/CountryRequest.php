<?php

namespace Modules\Admin\Http\Requests\Rss;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules()
    {
        $countryCodes = implode(',', config('redmedial.countries_codes'));

        return [
            'slug' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'size:2', "in:$countryCodes"],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
