<?php

namespace App\Shop\Products\Requests;

use App\Shop\Base\BaseFormRequest;

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
            'quantity' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'cover' => ['required', 'file', 'image:png,jpeg,jpg,gif'],
            'weight' => ['nullable', 'numeric', 'min:0']
        ];
    }
}
