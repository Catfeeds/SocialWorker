<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/16
 * Time: 15:53
 */

namespace App\Models;


class Cash extends Model
{
    protected $guarded = [];

    public function user()
    {
        $this->belongsTo('App\Models\User');
    }
}