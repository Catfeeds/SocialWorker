<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/16
 * Time: 15:53
 */

namespace App\Models;


/**
 * App\Models\Cash
 *
 * @property int $id
 * @property int $user_id
 * @property int $number
 * @property int $tax
 * @property int $status 1处理中 2已处理
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cash whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cash whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cash whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cash whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cash whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cash whereUserId($value)
 * @mixin \Eloquent
 */
class Cash extends Model
{
    protected $guarded = [];

    public function user()
    {
        $this->belongsTo('App\Models\User');
    }
}