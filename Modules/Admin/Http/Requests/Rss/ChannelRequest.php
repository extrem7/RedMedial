<?php

namespace Modules\Admin\Http\Requests\Rss;

use Feeds;
use Illuminate\Foundation\Http\FormRequest;
use SimplePie;

class ChannelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => ['nullable', 'exists:rss_countries,id'],
            'slug' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'feed' => ['required', 'string', 'max:255', 'url', function ($attribute, $value, $fail) {
                /* @var $feed SimplePie */
                $feed = Feeds::make($value, null, true);
                if ($feed->error()) $fail('Feed url is invalid.');
            },],
            'source' => ['nullable', 'string', 'max:255', 'url'],
            'description' => ['nullable', 'string'],
            'use_fulltext' => ['nullable', 'boolean'],
            'use_og' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,bmp,png'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
