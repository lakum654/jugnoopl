<?php

namespace App\Http\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class CityValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city'                  => 'required',
           
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}