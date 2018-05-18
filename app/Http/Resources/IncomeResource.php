<?php

namespace App\Http\Resources;

use App\Enum\IncomeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => self::convertType($this->type),
            'number' => (int)$this->number,
            'created_at' => (string)$this->created_at
        ];
    }

    public function convertType($value)
    {
        $type = [
            IncomeEnum::INVITE => '邀请好友',
            IncomeEnum::BEINVITED => '好友邀请',
            IncomeEnum::BUY => '申请设备',
            IncomeEnum::ONECONSUME => '一级好友消费',
            IncomeEnum::TWOCONSUME => '二级好友消费'
        ];

        return $type[$value];
    }
}
