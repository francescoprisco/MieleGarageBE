<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'payment_option_id' => 'required|exists:payment_options,id',
            'delivery_address_id' => 'required|exists:delivery_addresses,id',
            'total_amount' => 'required|numeric',
            'sub_total_amount' => 'required|numeric',
            'delivery_fee' => 'required|numeric',
            'spare_parts' => 'required',
        ];
    }
}
