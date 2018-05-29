<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/25
 * Time: 16:49
 */

namespace App\Http\Controllers\Api;


use App\Models\EquipmentOrderCode;

class EquipmentOrderCodeController extends ApiController
{
    public function show($id)
    {
        return EquipmentOrderCode::findOrFail($id)->code;
    }
}