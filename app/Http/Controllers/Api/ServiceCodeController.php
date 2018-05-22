<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/22
 * Time: 15:17
 */

namespace App\Http\Controllers\Api;


use App\Models\ServiceCode;

class ServiceCodeController extends ApiController
{
    public function show(ServiceCode $invitationCode)
    {
        return $invitationCode->value('code');
    }
}