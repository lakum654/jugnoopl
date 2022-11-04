<?php

namespace App\Http\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ShopkeeperValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'users'             => 'required|array',
            'store_name'        => 'required|string|min:2|max:500',
            'store_email'       => 'required|string|email|min:2|max:100',
            'gst_no'            => 'nullable|min:2|max:100',
            'store_mobile'      => 'required|numeric|not_in:0|digits:10',
            'country'           => 'required|min:2|max:100',
            'state'             => 'required|min:2|max:100',
            'city'              => 'required|min:2|max:100',
            'pincode'           => 'required|numeric|digits:6',
            'store_address'     => 'nullable|string||min:2|max:500',
            'verified'          => 'required|numeric|digits:1',
            'status'          => 'required|numeric|digits:1'
            // 'store_description'         => 'required|max:100',
            // 'logo'                      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'retailer_name.required' => 'Retailer Name field is Required.',
    //         'retailer_name.string'=>'Retailer Name should be string.',
    //         'retailer_name.max'=>'Retailer Name should not be maximum 30 Character.',
    //         'mobile_no.required'=>'Mobile Number field is Required.',
    //     ];
    // }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
