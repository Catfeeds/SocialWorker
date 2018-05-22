<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/22
 * Time: 22:41
 */

namespace App\Enum;


class ServiceOrderStatusEnum
{
    // 未支付
    const UNPAID = 1;

    // 已支付
    const PAYED = 2;

    // 已收款
    const CONFIRM = 3;

    // 已完成
    const COMPLETED = 4;
}