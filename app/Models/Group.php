<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/14
 * Time: 15:44
 */

namespace App\Models;


use App\Events\GroupCreated;

/**
 * App\Models\Group
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\InvitationCode $invitationCode
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereUserId($value)
 * @mixin \Eloquent
 */
class Group extends Model
{
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => GroupCreated::class
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function invitationCode()
    {
        return $this->hasOne('App\Models\InvitationCode');
    }
}