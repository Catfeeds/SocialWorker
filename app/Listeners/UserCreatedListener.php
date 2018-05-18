<?php

namespace App\Listeners;

use App\Enum\IncomeEnum;
use App\Events\UserCreated;
use App\Exceptions\UserNotFoundException;
use App\Models\Asset;
use App\Models\Group;
use App\Services\AssetService;
use DB;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedListener
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
     * @param UserCreated $event
     * @throws \Throwable
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;

        try {
            DB::transaction(function () use ($user) {
                // 添加用户资产信息
                Asset::create([
                    'user_id' => $user->id
                ]);

                // 为用户创建小组
                Group::create([
                    'user_id' => $user->id,
                    'name' => $user->nickname . '的小组'
                ]);

                // 如果通过邀请码注册，将用户加入邀请者小组
                if (request()->post('inviter')) {
                    $groupId = request()->post('inviter');
                    $user->groups()->attach($groupId);
                    $inviterId = Group::findOrFail($groupId)->user_id;

                    // 为邀请者与被邀请者增加资产
                    AssetService::income($inviterId, 'invite', $user->id);
                }
            });
        } catch (Exception $exception) {
            $user->forceDelete();
            throw $exception;
        }
    }
}
