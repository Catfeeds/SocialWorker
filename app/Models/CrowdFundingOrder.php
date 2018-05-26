<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/25
 * Time: 17:16
 */

namespace App\Models;


/**
 * App\Models\CrowdFundingOrder
 *
 * @property int $id
 * @property int $equipment_order_id
 * @property int $user_id
 * @property string $order_no
 * @property float $price
 * @property int $status
 * @property string|null $prepay_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\EquipmentOrder $equipmentOrder
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder whereEquipmentOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder wherePrepayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdFundingOrder whereUserId($value)
 * @mixin \Eloquent
 */
class CrowdFundingOrder extends Model
{
    protected $guarded = [];

    public function equipmentOrder()
    {
        return $this->belongsTo('App\Models\EquipmentOrder');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}