<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/16
 * Time: 14:33
 */

namespace App\Services;


use App\Enum\IncomeEnum;
use App\Models\Asset;
use App\Models\AssetRecord;
use App\Models\User;
use App\Services\Tokens\TokenFactory;
use Carbon\Carbon;

class AssetService
{
    /**
     * 资产收入
     *
     * @param $uid
     * @param $type 'invite || buy || consume'
     * @param null $other
     * @throws \Exception
     */
    public static function income($uid, $type, $other = null)
    {
        switch ($type) {
            case 'invite':
                if (!$other) throw new \Exception('请输入被邀请者ID');
                self::add($uid, IncomeEnum::INVITE, $other);
                self::add($other, IncomeEnum::BEINVITED);
                break;
            case 'buy':
                if (!$other) throw new \Exception('请输入设备序列号');
                self::add($uid, IncomeEnum::BUY, $other);
                break;
            case 'consume':
                if (!$other) throw new \Exception('请输入消费金额');
                self::rebate($uid, $other);
                break;
            case 'service':
                if (!$other) throw new \Exception('请输入服务金额');
                self::add($uid, IncomeEnum::SERVICE, $other);
                break;
            default:
                throw new \Exception('请输入正确的类型');
        }
    }

    /**
     * 好友消费返利
     *
     * @param $uid
     * @param $price
     * @param int $level
     * @throws \Exception
     */
    private static function rebate($uid, $price, $level = 1)
    {
        if ($level == 3) return;

        foreach (User::findOrFail($uid)->groups as $group) {
            $inviterId = $group->user_id;

            if ($level == 1) self::add($inviterId, IncomeEnum::ONECONSUME, $price);
            elseif ($level == 2) self::add($inviterId, IncomeEnum::TWOCONSUME, $price);

            self::rebate($inviterId, $price, $level + 1);
        }
    }

    /**
     * 添加用户资产
     *
     * @param $uid
     * @param $type
     * @param null $other
     * @throws \Exception
     */
    private static function add($uid, $type, $other = null)
    {
        $assetRecord = new AssetRecord();
        $assetRecord->user_id = $uid;
        $assetRecord->type = $type;
        $assetRecord->other = $other;

        switch ($type) {
            case IncomeEnum::INVITE:
                $assetRecord->number = 29;
                $assetRecord->transferred = 0;
                Asset::where('user_id', $uid)->increment('disabled', 29);
                break;
            case IncomeEnum::BEINVITED:
                $assetRecord->number = 29;
                $assetRecord->transferred = 0;
                Asset::where('user_id', $uid)->increment('disabled', 29);
                break;
            case IncomeEnum::BUY:
                $assetRecord->number = 299;
                $assetRecord->transferred = 0;
                Asset::where('user_id', $uid)->increment('disabled', 299);
                break;
            case IncomeEnum::ONECONSUME:
                $assetRecord->number = round($other * 0.1);
                $assetRecord->transferred = round($other * 0.1);
                Asset::where('user_id', $uid)->increment('available', round($other * 0.1));
                break;
            case IncomeEnum::TWOCONSUME:
                $assetRecord->number = round($other * 0.05);
                $assetRecord->transferred = round($other * 0.05);
                Asset::where('user_id', $uid)->increment('available', round($other * 0.05));
                break;
            case IncomeEnum::SERVICE:
                $assetRecord->number = round($other);
                $assetRecord->transferred = round($other);
                Asset::where('user_id', $uid)->increment('available', round($other));
                break;
            default:
                throw new \Exception('请输入正确的类型');
        }

        $assetRecord->save();
    }

    public static function transfer($uid, $type)
    {
        switch ($type) {
            case 'invite':
                $assetRecord = AssetRecord::where('other', $uid)
                    ->where('type', IncomeEnum::INVITE)
                    ->first();
                if ($assetRecord && $assetRecord->transferred == 0) {
                    $assetRecord->increment('transferred', $assetRecord->number);
                    $asset = Asset::where('user_id', $assetRecord->user_id)->first();
                    $asset->increment('available', $assetRecord->number);
                    $asset->decrement('disabled', $assetRecord->number);
                }
                break;
            case 'beinvite':
                $assetRecord = AssetRecord::where('user_id', $uid)
                    ->where('type', IncomeEnum::BEINVITED)
                    ->first();
                if ($assetRecord
                    && User::findOrFail($uid)->bindingsEquipment()->count() > 0
                    && $assetRecord->transferred < $assetRecord->number
                    && Carbon::today()->toDateString()
                    != Carbon::parse($assetRecord->updated_at)->toDateString()) {

                    $asset = Asset::where('user_id', $uid)->first();
                    $assetRecord->increment('transferred');
                    $asset->increment('available');
                    $asset->decrement('disabled');
                }
                break;
            case 'equipment':
                $assetRecord = AssetRecord::where('type', IncomeEnum::BUY)
                    ->where('transferred', '<', 100)
                    ->whereDate('updated_at', '<>', Carbon::now()->toDateString())
                    ->whereHas('user', function ($query) {
                        $query->has('bindingsEquipment');
                    })
                    ->get();
                $users = $assetRecord->pluck('user_id')->toArray();

                AssetRecord::where('type', IncomeEnum::BUY)
                    ->where('transferred', '<', 100)
                    ->whereDate('updated_at', '<>', Carbon::now()->toDateString())
                    ->whereHas('user', function ($query) {
                        $query->has('bindingsEquipment');
                    })
                    ->increment('transferred');
                Asset::whereIn('user_id', $users)
                    ->increment('available');
                Asset::whereIn('user_id', $users)
                    ->decrement('disabled');
                break;
            default:
                throw new \Exception('请输入正确的类型');
        }
    }
}