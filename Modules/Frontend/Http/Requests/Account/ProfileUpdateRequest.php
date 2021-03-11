<?php

namespace Modules\Frontend\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string255'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->user()->id],
            'password' => ['nullable', 'string', 'min:8', 'max:24', 'numbers', 'letters', 'confirmed']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
