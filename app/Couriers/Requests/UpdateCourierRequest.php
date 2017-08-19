<?php

namespace App\Couriers\Requests;

use App\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateCourierRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('couriers')->ignore($this->segment(3))]
        ];
    }
}