<?php

namespace Modules\Admin\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $types = collect(Article::$statuses)->keys()->implode(',');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:510'],
            'image' => [$update ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,bmp,png'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'authors' => ['nullable', 'string', 'max:255'],
            'original' => ['nullable', 'string', 'max:255', 'url'],
            'status' => ['nullable', "in:$types"],
        ];
    }
}
