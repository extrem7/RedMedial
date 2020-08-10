<?php

namespace Modules\Api\Http\Requests\Users;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules()
    {
        $update = request()->isMethod('PATCH');
        if ($update) $user = Auth::user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . ($update ? $user->id : '')],
            'password' => [$update ? 'nullable' : 'required', 'string', 'min:8'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,bmp,png', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'numeric', 'exists:rss_countries,id'],
            'device' => [$update ? 'nullable' : 'required', 'string']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
