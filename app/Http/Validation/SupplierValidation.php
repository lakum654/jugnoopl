<?php

namespace App\Http\validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class SupplierValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'users'           => 'required|array',
            'store_name'      => 'required|string|max:500|min:2',
            'store_email'     => 'required|email|max:100|min:2',
            'gst_no'          => 'nullable|max:50|min:2',
            'store_mobile'    => 'required|numeric|not_in:0|digits:10',
            'country'         => 'required|max:16|min:1',
            'state'           => 'required|string|max:100|min:2',
            'city'            => 'required|string|max:100|min:2,',
            'pincode'         => 'required|numeric|not_in:0|digits:6',
            'store_address'   => 'nullable|string|min:2|max:500',
            'verified_store'        => 'required|numeric|digits:1',
            'status'          => 'required|numeric|digits:1'
            // 'profile_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
