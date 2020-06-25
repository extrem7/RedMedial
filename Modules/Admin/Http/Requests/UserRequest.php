<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $update = request()->isMethod('PATCH');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . ($update ? $this->user->id : '')],
            'password' => [$update ? 'nullable' : 'required', 'string', 'min:8'],
            'role' => ['required', 'numeric', 'exists:roles,id'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,bmp,png'],
        ];
    }
}
