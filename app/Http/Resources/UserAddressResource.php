<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 9:59
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'province' => $this->province,
            'city' => $this->city,
            'area' => $this->area,
            'detail' => $this->detail,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at
        ];
    }
}