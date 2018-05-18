<?php

namespace App\Listeners;

use App\Events\GroupCreated;
use App\Exceptions\UserNotFoundException;
use App\Models\InvitationCode;
use App\Services\WeChatQRCode;
use DB;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GroupCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param GroupCreated $event
     * @throws \Throwable
     */
    public function handle(GroupCreated $event)
    {
        $group = $event->group;

        try {
            DB::transaction(function () use ($group) {
                // 为用户小组生成邀请码
                InvitationCode::create([
                    'group_id' => $group->id,
                    'code' => WeChatQRCode::get($group->id)
                ]);
            });
        } catch (Exception $exception) {
            $group->delete();
            throw $exception;
        }
    }
}
