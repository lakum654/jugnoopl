<?php

namespace App\Http\validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ProfileValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'             => 'required|string|max:30',
            'email'            => 'required|email|max:30',
            'mobile'           => 'nullable|numeric|not_in:0|digits:10',
            'pincode'          => 'nullable|digits:6',
            'profile_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Name field is Required.',
            'name.string'          => 'Name should be string.',
            'name.max'             => 'Name should not be maximum 30 Character.',
            'email.required'       => 'Email field is Required.',
            'email.email'          => 'Please enter valid Email.',
            'email.max'            => 'Email should not be maximum 30 Character.',
            'mobile.numeric'       => 'Mobile No should be Numeric.',
            'mobile.not_in'        => 'Please enter valid Mobile No.',
            'mobile.digits'        => 'Mobile No. Must be 10 digits.',
            'profile_image.mimes'  =>'Profile Pic must be a file of type: png, jpg, jpeg.',
            'profile_image.max'    =>'Profile Pic should not be more than 2 MB.'

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
