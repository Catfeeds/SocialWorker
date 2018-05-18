<?php

namespace App\Http\Resources;

use App\Enum\CashStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class CashResource extends JsonResource
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
            'number' => (string)$this->number,
            'status' => self::convertStatus($this->status),
            'created_at' => (string)$this->created_at
        ];
    }

    public static function convertStatus($value)
    {
        $status = [
            CashStatusEnum::HANDLING => '处理中',
            CashStatusEnum::HANDLED => '已处理'
        ];

        return $status[$value];
    }
}
