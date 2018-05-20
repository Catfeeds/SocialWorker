<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/14
 * Time: 16:18
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\GroupResource;
use App\Models\Group;

class GroupController extends ApiController
{
    public function show(Group $group)
    {
        return $this->success(new GroupResource($group));
    }

    public function inviteInfo($id)
    {
        $group = Group::findOrFail($id);
        $user = $group->user;

        return $this->success([
            'avatar' => $user->avatar,
            'nickname' => $user->nickname,
            'days' => ceil((time() - $user->created_at->getTimestamp()) / 86400),
            'income' => $user->asset->disabled + $user->asset->available,
            'invitation_code' => config('app.url') . '/api/invitation_codes/' . $group->invitationCode->id
        ]);
    }
}