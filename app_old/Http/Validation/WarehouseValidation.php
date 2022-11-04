<?php

namespace App\Http\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'users'           => 'required|array',
            'suppliers'       => 'required|array',
            'store_name'      => 'required|string|max:500|min:2',
            'store_email'     => 'required|email|max:100|min:2',
            'gst_no'          => 'nullable|max:50|min:2',
            'store_mobile'    => 'required|numeric|not_in:0|digits:10',
            'country'         => 'required|min:2|max:200',
            'state'           => 'required|min:2|max:200',
            'city'            => 'required|min:2|max:200',
            'pincode'         => 'required|numeric|not_in:0|digits:6',
            'store_address'   => 'nullable|string|min:2|max:500',

            // 'profile_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
