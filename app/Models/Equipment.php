<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/18
 * Time: 11:20
 */

namespace App\Models;


class Equipment extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App/Models/EquipmentCategory');
    }
}