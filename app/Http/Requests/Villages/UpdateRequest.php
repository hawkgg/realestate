<?php

namespace App\Http\Requests\Villages;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|max:255|unique:villages,name,'.$this->village,
            'address' => 'required|max:255',
            'square' => 'integer|between:0,1000',
            'phone' => 'integer|nullable|max_digits:15',
            'youtube_link' => 'nullable|max:255|url',
            'photo' => 'mimes:jpeg,jpg,png',
            'presentation' => 'mimes:pdf|max:20480',
        ];
    }
}
