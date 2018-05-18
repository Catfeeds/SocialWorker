<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'creator' => (new UserResource($this->user))->show(['id', 'nickname', 'avatar']),
            'users_num' => $this->users()->count(),
            'users' => UserResource::collection($this->users)->show(['id', 'nickname', 'avatar'])
        ];
    }
}
