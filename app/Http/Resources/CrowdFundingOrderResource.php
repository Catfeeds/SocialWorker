<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/26
 * Time: 10:56
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CrowdFundingOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => (new UserResource($this->user))->show(['id', 'nickname', 'name', 'avatar']),
            'order_no' => $this->order_no,
            'price' => $this->price,
            'status' => $this->status ? '已支付' : '未支付',
            'created_at' => $this->created_at
        ];
    }
}