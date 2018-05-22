<?php

namespace App\Http\Requests;


use App\Exceptions\BaseException;
use App\Models\Equipment;

class BindEquipment extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'serial_no' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Equipment::where('serial_no', $value)->first()) {
                        throw new BaseException('设备序列号错误');
                    }
                }
            ]
        ];
    }
}
