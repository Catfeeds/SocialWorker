<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserGroupResource extends JsonResource
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
            'invitation_code' => config('app.url') . '/api/invitation_codes/' . $this->invitationCode->value('id'),
            'users_num' => $this->users()->count(),
            'users' => UserResource::collection($this->users()->paginate(10))->show(['avatar'])
        ];
    }
}
