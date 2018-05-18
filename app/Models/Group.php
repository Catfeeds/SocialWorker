<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/14
 * Time: 15:44
 */

namespace App\Models;


use App\Events\GroupCreated;

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