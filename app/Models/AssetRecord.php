<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/15
 * Time: 18:13
 */

namespace App\Models;


/**
 * App\Models\AssetRecord
 *
 * @property int $id
 * @property int $user_id
 * @property int $type 1邀请好友 2好友邀请 3购买设备 4一级好友消费 5二级好友消费
 * @property int $number
 * @property int $transferred
 * @property string|null $other
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereTransferred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AssetRecord whereUserId($value)
 * @mixin \Eloquent
 */
class AssetRecord extends Model
{
    protected $guarded = [];
}