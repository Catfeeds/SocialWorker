<?php

namespace App\Http\Resources;

use App\Enum\CashStatusEnum;
use App\Models\User;
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
            'user' => (new UserResource($this->user))->show(['id', 'name', 'nickname','phone']),
            'number' => (string)$this->number,
            'tax' => $this->tax,
            'actual' => $this->number - $this->tax,
            'status' => self::convertStatus($this->status),
            'created_at' => (string)$this->created_at
        ];
    }

    public static function convertStatus($value)
    {
        $status = [
            CashStatusEnum::HANDLING => '处理中',
            CashStatusEnum::ADOPT => '已通过',
            CashStatusEnum::REFUSE => '已拒绝'
        ];

        return $status[$value];
    }
}
