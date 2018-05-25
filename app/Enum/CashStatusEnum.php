<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/17
 * Time: 15:37
 */

namespace App\Enum;


class CashStatusEnum
{
    // 处理中
    const HANDLING = 1;

    // 已通过
    const ADOPT = 2;

    // 已拒绝
    const REFUSE = 3;
}