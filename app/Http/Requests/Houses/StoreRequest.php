<?php

namespace App\Http\Requests\Houses;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:houses',
            'price' => 'numeric|nullable|between:0,100000000',
            'currency' => 'integer',
            'floors' => 'integer|nullable|between:0,150',
            'bedrooms' => 'integer|nullable|between:0,100',
            'square' => 'integer|between:0,1000',
            'estate_type' => 'integer',
            'village' => 'integer',
            'photos.*' => 'mimes:jpeg,jpg,png',
        ];
    }
}
