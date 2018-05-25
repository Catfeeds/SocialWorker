<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 10:27
 */

namespace App\Http\Requests;


class StoreAddress extends Request
{
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
            'phone' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^1[3-9]\d{9}$/', $value)) {
                        return $fail($attribute . ' is invalid');
                    }
                }
            ],
            'city' => 'required',
            'detail' => 'required'
        ];
    }
}