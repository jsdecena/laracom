<?php

namespace App\Shop\Addresses\Requests;

use App\Shop\Base\BaseFormRequest;

class UpdateAddressRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => ['required'],
            'address_1' => ['required']
        ];
    }
}
