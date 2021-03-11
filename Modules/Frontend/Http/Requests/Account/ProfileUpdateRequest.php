<?php

namespace Modules\Frontend\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string255'],
            'url' => ['required', 'active_url'],
            'facebook' => [
                'nullable',
                'url',
                'regex:/(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?/',
            ],
            'phone' => ['required', 'string', 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'],
            'instagram' => ['nullable', 'regex:/^([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)$/'],
            'twitter' => ['nullable', 'regex:/^@?(\w){1,15}$/'],
            'rss' => ['nullable', 'url', 'active_rss'],
            'comment' => ['nullable', 'string255'],
            'statisticImage' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return array_merge(parent::attributes(), [
            'rss' => 'link'
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
