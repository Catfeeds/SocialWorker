<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/15
 * Time: 10:58
 */

namespace App\Models;


/**
 * App\Models\InvitationCode
 *
 * @property int $id
 * @property int $group_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property mixed|null $code
 * @property-read \App\Models\Group $group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvitationCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvitationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvitationCode whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvitationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InvitationCode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvitationCode extends Model
{
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
}