<?php

namespace App\Products\Requests;

use App\Base\BaseFormRequest;

class CreateProductRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => ['required'],
            'name' => ['required', 'unique:products'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required']
        ];
    }
}