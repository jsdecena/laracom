<?php

namespace App\Shop\AttributeValues\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateAttributeValueRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => ['required']
        ];
    }
}
