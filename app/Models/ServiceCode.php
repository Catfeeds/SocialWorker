<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/22
 * Time: 15:02
 */

namespace App\Models;


/**
 * App\Models\ServiceCode
 *
 * @property int $id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property mixed|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceCode whereUserId($value)
 * @mixin \Eloquent
 */
class ServiceCode extends Model
{
    protected $guarded = [];
}