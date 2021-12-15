<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'code' => 'max:250',
            'name' => 'required|max:250',
            'brand' => 'max:250',
            'category_id' => 'nullable|exists:product_categories',
            'price' => 'required',
            'short_description' => '',
            'long_description' => '', 
            'uom' => 'required',
            'meta_title' => 'max:60',
            'meta_keyword' => 'max:160',
            'meta_description' => 'max:160',
        ];
    }
}
