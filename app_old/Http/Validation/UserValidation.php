<?php

namespace App\Http\validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UserValidation extends FormRequest
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
            'role'             => 'required',
            'mobile'           => 'required|numeric|not_in:0|digits:10',
            'password'         => 'nullable|max:16|min:6',
            'state'            => 'required',
            'city'             => 'required',
            'pincode'          => 'required|digits:6',
            'address'          => 'nullable|min:3|max:1000',
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
            'mobile.required'      => 'Mobile No is Required.',
            'mobile.numeric'       => 'Mobile No should be Numeric.',
            'mobile.not_in'        => 'Please enter valid Mobile No.',
            'mobile.digits'        => 'Mobile No. Must be 10 digits.',
            'password.max'         => 'Password should not be maximum 16 Character.',
            'password.min'         => 'Password should not be minimum 6 Character.',
            'password.same'        => 'Password should be same as confirm Password.',
            'confirm_password.max' => 'Confirm Password should not be maximum 16 Character.',
            'confirm_password.min' => 'Confirm Password should not be minimum 6 Character.',
            'profile_image.mimes'  => 'Profile Pic must be a file of type: png, jpg, jpeg.',
            'profile_image.max'    => 'Profile Pic should not be more than 2 MB.'

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
