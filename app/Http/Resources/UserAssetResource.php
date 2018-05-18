<?php

namespace App\Http\Resources;

use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssetResource extends JsonResource
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
            'total' => (int)$this->available + $this->disabled,
            'available' => (int)$this->available,
            'disabled' => (int)$this->disabled,
            'incomes' => IncomeResource::collection(TokenFactory::getCurrentUser()->incomes),
            'cashes' => CashResource::collection(TokenFactory::getCurrentUser()->cashes)
        ];
    }
}
