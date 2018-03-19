<?php

namespace Laracommerce\Core\Carts\Requests;

use Laracommerce\Core\Base\BaseFormRequest;

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
            'courier' => ['required'],
            'billing_address' => ['required'],
        ];
    }
}
