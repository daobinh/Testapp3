<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberEditRequest extends FormRequest
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
            'name' => 'bail|required|alpha|max:100',
            'address' => 'bail|required|max:300',
            'age' => 'bail|required|numeric|digits_between:1,2',
            'photo' => 'bail|image|mimes:png,jpeg,gif|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name is required and cannot be empty',
            'name.max' => 'The name must be less than 100 characters',
            'name.alpha' => 'The name must be alphabetic characters, with no special characters.',
            'address.required' => 'The address is required and cannot be empty',
            'address.max' => 'The address must be less than 300 characters',
            'age.required' => 'The age is required and cannot be empty',
            'age.numeric' => 'The age must be a number',
            'age.digits_between' => 'The age must have a length between the given 1 and 2 digits',
            'photo.image' => 'Must be photo',
            'photo.mimes' => 'The photo must be in jpg,png,gif type',
            'photo.max' => 'The photo must not exceed 10MB in size'
        ];
    }
}
