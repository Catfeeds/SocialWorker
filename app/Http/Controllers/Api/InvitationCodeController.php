<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/15
 * Time: 15:22
 */

namespace App\Http\Controllers\Api;


use App\Models\InvitationCode;

class InvitationCodeController extends ApiController
{
    public function show(InvitationCode $invitationCode)
    {
        return $invitationCode->code;
    }
}