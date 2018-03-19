<?php

namespace Laracommerce\Core\Cart\Requests;

use Laracommerce\Core\Base\BaseFormRequest;

/**
 * Class CartCheckoutRequest
 * @package Laracommerce\Core\Cart\Requests
 * @codeCoverageIgnore
 */
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
            'billing_address' => ['required']
        ];
    }
}
