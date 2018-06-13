<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/6/13
 * Time: 15:38
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class AssessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'score' => $this->score,
            'type' => $this->type
        ];
    }
}