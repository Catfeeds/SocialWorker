<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/17
 * Time: 14:58
 */

namespace App\Models;


/**
 * App\Models\Receivable
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $id_card_no
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Receivable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Receivable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Receivable whereIdCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Receivable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Receivable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Receivable whereUserId($value)
 * @mixin \Eloquent
 */
class Receivable extends Model
{
    protected $guarded = [];
}