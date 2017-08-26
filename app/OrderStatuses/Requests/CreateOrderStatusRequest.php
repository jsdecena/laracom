<?php

namespace App\OrderStatuses\Requests;

use App\Base\BaseFormRequest;

class CreateOrderStatusRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:order_statuses']
        ];
    }
}