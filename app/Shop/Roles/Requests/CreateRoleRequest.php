<?php

namespace App\Shop\Roles\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateRoleRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:roles']
        ];
    }
}
