<?php

namespace App\Customers\Requests;

use App\Base\BaseFormRequest;

class SendInquiryRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email']
        ];
    }
}