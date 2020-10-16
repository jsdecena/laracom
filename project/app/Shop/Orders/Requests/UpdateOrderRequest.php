<?php

namespace App\Shop\Orders\Requests;

use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_status_id' => ['required'],
            'total_paid' => ['nullable', 'numeric']
        ];
    }
}
