<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiNewCategory extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
         // all can
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
            'name' => 'required|string|max:256|unique:categories,name',
            'is_subcat' => 'required|boolean',
            'parent_of' => 'required_if:is_subcat,true|integer|exists:categories,id',
        ];
    }
}
