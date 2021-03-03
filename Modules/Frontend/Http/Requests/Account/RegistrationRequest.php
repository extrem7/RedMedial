<?php

namespace Modules\Frontend\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'media_name' => ['required', 'string255'],
            'url' => ['required', 'active_url'],
            'phone' => ['nullable', 'string', 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'],
            'password' => ['required', 'string', 'min:8', 'max:24', 'numbers', 'letters', 'confirmed']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
