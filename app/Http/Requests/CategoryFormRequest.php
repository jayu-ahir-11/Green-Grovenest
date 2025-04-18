<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CategoryFormRequest extends FormRequest
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
            'name'=> [
                'required',
                'string'
            ],
            'slug'=> [
                'required',
                'string'
            ],
            'description'=> [
                'required',
            ],
            'image'=>[
                'nullable',
            ],
            'meta_titel'=> [
                'required',
                'string',
            ],
            'meta_description'=> [
                'required',
                'string',
            ],
            'meta_keyword'=> [
                'required',
                'string',
            ],
            
        ];
    }
}
