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
            'products' => $this->snap_content,
            'price' => $this->price,
            'raise' => $this->when($this->type == 2, (int)$this->raise),
            'code' => $this->when($this->type == 2, config('app.url') . '/api/funding_codes/' . $this->code->id),
            'type' => $this->convertType($this->type),
            'status' => $this->status ? '已支付' : '未支付',
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
}