<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/24
 * Time: 11:55
 */

namespace App\Models;


/**
 * App\Models\EquipmentOrderCode
 *
 * @property int $id
 * @property int $equipment_order_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property mixed|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrderCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrderCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrderCode whereEquipmentOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrderCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrderCode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EquipmentOrderCode extends Model
{
    protected $guarded = [];
}