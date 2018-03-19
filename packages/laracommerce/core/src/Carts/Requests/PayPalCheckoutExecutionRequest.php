<?php

namespace Laracommerce\Core\Carts\Requests;

use Laracommerce\Core\Base\BaseFormRequest;

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
            'courier' => ['required'],
            'billing_address' => ['required'],
            'payment' => ['required']
        ];
    }
}
