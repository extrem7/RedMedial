<?php

namespace Modules\Api\Http\Requests\Users;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,bmp,png', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'numeric', 'exists:rss_countries,id'],
            'device' => ['required', 'string']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
