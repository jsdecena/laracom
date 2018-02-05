<?php

namespace App\Shop\Countries\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'iso' => ['max:2'],
            'iso3' => ['max:3'],
            'numcode' => ['numeric'],
            'phonecode' => ['numeric']
        ];
    }
}
