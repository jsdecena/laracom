<?php

namespace App\Shop\Carts\Requests;

use App\Shop\Base\BaseFormRequest;

class PayPalCheckoutExecutionRequest extends BaseFormRequest implements CheckoutInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paymentId' => ['required'],
            'PayerID' => ['required'],
            'billing_address' => ['required'],
            'payment' => ['required']
        ];
    }
}
