<?php

namespace App\Cart\Requests;

use App\Base\BaseFormRequest;

class CartCheckoutRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'courier' => ['required'],
            'address' => ['required'],
            'payment' => ['required']
        ];
    }
}