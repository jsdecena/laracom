<?php

namespace App\Shop\Carts\Requests;

use App\Shop\Base\BaseFormRequest;

class StripeExecutionRequest extends BaseFormRequest implements CheckoutInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripeToken' => ['required'],
            'billing_address' => ['required'],
        ];
    }
}
