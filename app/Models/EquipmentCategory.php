<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/18
 * Time: 11:22
 */

namespace App\Models;


/**
 * App\Models\EquipmentCategory
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentCategory wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Equipment[] $equipments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Equipment[] $equipment
 */
class EquipmentCategory extends Model
{
    protected $guarded = [];

    public function equipment()
    {
        return $this->hasMany('App\Models\Equipment');
    }
}