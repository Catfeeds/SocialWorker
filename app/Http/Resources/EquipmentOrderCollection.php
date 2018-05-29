<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/29
 * Time: 17:24
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class EquipmentOrderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => EquipmentOrderResource::collection($this->collection),
            'count' => $this->count(),
            'total' => $this->total(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'has_more_pages' => $this->hasMorePages()
        ];
    }
}