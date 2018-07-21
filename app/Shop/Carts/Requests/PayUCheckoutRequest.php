<?php namespace App\Shop\Carts\Requests;

/**
 * Created by PhpStorm.
 * User: mufaddaln
 * Date: 13/7/18
 * Time: 4:46 PM
 */

use App\Shop\Base\BaseFormRequest;

class PayUCheckoutRequest extends BaseFormRequest implements CheckoutInterface
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
            'billing_address' => ['required'],
        ];
    }
}
