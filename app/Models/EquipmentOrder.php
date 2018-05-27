<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/22
 * Time: 16:10
 */

namespace App\Models;


use App\Events\EquipmentOrderCreated;
use App\Services\Tokens\TokenFactory;

/**
 * App\Models\EquipmentOrder
 *
 * @property int $id
 * @property int $user_id
 * @property string $order_no
 * @property float $price
 * @property float $raise
 * @property mixed $snap_content
 * @property int $status 0未支付 1已支付
 * @property string|null $prepay_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder wherePrepayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereRaise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereSnapContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereUserId($value)
 * @mixin \Eloquent
 * @property int $type 1购买 2众筹
 * @property-read \App\Models\EquipmentOrderCode $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EquipmentOrder whereType($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CrowdFundingOrder[] $crowdFundingOrders
 */
class EquipmentOrder extends Model
{
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => EquipmentOrderCreated::class
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function code()
    {
        return $this->hasOne('App\Models\EquipmentOrderCode')->withDefault();
    }

    public function crowdFundingOrders()
    {
        return $this->hasMany('App\Models\CrowdFundingOrder');
    }

    public static function generate($ids, $type = 1)
    {
        $products = EquipmentCategory::whereIn('id', $ids)->get(['name', 'price']);

        $totalPrice = $products->sum('price');

        $order = self::create([
            'user_id' => TokenFactory::getCurrentUID(),
            'order_no' => makeOrderNo(),
            'price' => $totalPrice,
            'snap_content' => $products,
            'type' => $type
        ]);

        return $order;
    }
}