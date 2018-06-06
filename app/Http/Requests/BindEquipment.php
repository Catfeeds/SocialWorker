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
            'serial_no' => ['required']
        ];
    }
}
