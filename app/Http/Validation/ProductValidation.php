<?php

namespace App\Http\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ProductValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'         => 'required|string|min:2|max:500',
            'sku'           => 'required|string|min:2|max:200',
            'category'      => 'required',
            'sub_category'  => 'required',
            'brand_id'      => 'required',
            'unit_id'       => 'required',
            'weight'       =>  'required',
            'status'        => 'required',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
