<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 0:28
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => (new UserResource($this->user))->show(['id', 'nickname', 'phone']),
            'order_no' => $this->order_no,
            'products' => json_decode($this->snap_content, true),
            'price' => $this->price,
            'raise' => $this->when($this->type == 2, (int)$this->raise),
            'code' => $this->when($this->type == 2, config('app.url') . '/api/funding_codes/' . $this->code->id),
            'type' => $this->convertType($this->type),
            'status' => $this->convertStatus((int)$this->status),
            'serial_no' => $this->serial_no,
            'courier_no' => $this->courier_no,
            'order_type' => '申请订单',
            'address' => new UserAddressResource($this->user->address),
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at
        ];
    }

    public function convertType($value)
    {
        $type = [
            1 => '购买',
            2 => '众筹'
        ];

        return $type[$value];
    }

    public function convertStatus($value)
    {
        $status = [
            0 => '未支付',
            1 => '待发货',
            2 => '已发货'
        ];

        return $status[$value];
    }
}