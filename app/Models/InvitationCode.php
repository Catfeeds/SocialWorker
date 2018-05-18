<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/15
 * Time: 10:58
 */

namespace App\Models;


class InvitationCode extends Model
{
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
}