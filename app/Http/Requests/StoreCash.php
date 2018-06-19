<?php

namespace App\Http\Requests;


use App\Services\Tokens\TokenFactory;

class StoreCash extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'required|integer|between:1,' . TokenFactory::getCurrentUser()->asset->available
        ];
    }
}
