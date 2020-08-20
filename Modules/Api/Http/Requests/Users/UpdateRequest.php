<?php

namespace Modules\Api\Http\Requests\Users;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        /* @var $user User */
        $user = Auth::user();

        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,bmp,png', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'numeric', 'exists:rss_countries,id'],
            'settings' => ['nullable', 'string']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
