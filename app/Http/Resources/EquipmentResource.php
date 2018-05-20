<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
            'serial_no' => $this->serial_no,
            'category' => $this->category->name,
            'price' => $this->category->price,
            'status' => $this->convertStatus($this->status),
            'user' => $this->status ? (new UserResource($this->user))->show(['id', 'nickname','phone']) : '-',
            'created_at' => (string)$this->created_at,
            'updated_at' => $this->status ? (string)$this->updated_at : '-'
        ];
    }

    public function convertStatus($value)
    {
        $status = [0 => '未绑定', 1 => '已绑定'];

        return $status[$value];
    }
}
