<?php

namespace App\Http\validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ResetValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password'     => 'required',
            'password'         => 'required|max:16|min:6',
            'confirm_password' => 'required|same:confirm_password',
        ];
    }

    public function messages()
    {
        return [
            // 'password.min'         => 'Password should not be minimum 6 Character.',
            // 'password.same'        => 'Password should be same as confirm Password.',
            // 'confirm_password.max' => 'Confirm Password should not be maximum 16 Character.',
            // 'confirm_password.min' => 'Confirm Password should not be minimum 6 Character.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
