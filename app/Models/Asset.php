<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/15
 * Time: 18:13
 */

namespace App\Models;


/**
 * App\Models\Asset
 *
 * @property int $id
 * @property int $user_id
 * @property int $available
 * @property int $disabled
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Asset whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Asset whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Asset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Asset whereUserId($value)
 * @mixin \Eloquent
 */
class Asset extends Model
{
    protected $guarded = [];
}