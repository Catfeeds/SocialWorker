<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 14:09
 */

namespace App\Http\Resources;


use App\Enum\ServiceOrderStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => (new UserResource($this->user))->show(['id', 'nickname', 'phone']),
            'inspector' => (new UserResource($this->inspector))->show(['id', 'nickname', 'phone']),
            'order_no' => $this->order_no,
            'price' => $this->price,
            'service' => (new ServiceResource($this->service)),
            'detection_result' => $this->detection_result,
            'status' => $this->convertStatus($this->status),
            'paid_at' => $this->when($this->paid_at, (string)$this->paid_at),
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at
        ];
    }

    public function convertStatus($value)
    {
        $status = [
            ServiceOrderStatusEnum::UNPAID => '未支付',
            ServiceOrderStatusEnum::PAYED => '现金支付',
            ServiceOrderStatusEnum::CONFIRM => '已收款',
            ServiceOrderStatusEnum::COMPLETED => '已完成'
        ];

        return $status[$value];
    }
}