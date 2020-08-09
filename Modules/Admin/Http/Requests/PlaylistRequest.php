<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaylistRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'videos' => ['required', 'array'],
            'videos.*.title' => ['required', 'string'],
            'videos.*.id' => ['required', 'string'],
            'videos.*.duration' => ['nullable', 'string'],

            'country_id' => ['nullable', 'exists:rss_countries,id'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
