<?php

namespace App\Http\Requests;

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
        return auth()->check();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'meta_title' => 'SEO Title',
            'meta_description' => 'SEO Description',
            'meta_keyword' => 'SEO Keywords',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:150',
            'date' => 'required|date',
            'category_id' => '',
            'news_image' => 'nullable|max:5000',
            'contents' => 'required',
            'visibility' => '',
            'teaser' => 'required',
            'is_featured' => '',
            'meta_title' => 'max:60',
            'meta_description' => 'max:160',
            'meta_keyword' => 'max:160',
        ];
    }
}
