<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenderRequest extends FormRequest
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
            'name' => 'required|string',
            'status' => 'required|boolean'
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'     => 'Gender name is required.',
            'name.string'       => 'Gender name must be string.',
            'status.required'   => 'Gender status must be active or in-active.',
            'status.boolean'    => 'Gender status must be active or in-active.'
        ];
    }
}
