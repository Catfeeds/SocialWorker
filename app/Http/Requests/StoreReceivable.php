<?php

namespace App\Http\Requests;


class StoreReceivable extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'between:2,10',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[\x{4e00}-\x{9fa5}]{0,}$/u', $value)) {
                        return $fail($attribute . ' is invalid');
                    }
                }
            ],
            'id_card_no' => [
                'required',
                'size:18',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/', $value)) {
                        return $fail($attribute . ' is invalid');
                    }
                }
            ]
        ];
    }
}
