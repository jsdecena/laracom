<?php

namespace App\Shop\Cart\Requests;

use App\Shop\Base\BaseFormRequest;

/**
 * Class CartCheckoutRequest
 * @package App\Shop\Cart\Requests
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
            'billing_address' => ['required']
        ];
    }
}
