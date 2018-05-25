<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 13:54
 */

namespace App\Models;


/**
 * App\Models\ServiceOrder
 *
 * @property int $id
 * @property int $user_id
 * @property int $inspector_id
 * @property int $service_id
 * @property string $order_no
 * @property float $price
 * @property string|null $detection_result
 * @property int $status 1未支付 2现金支付 3已收款 4已完成
 * @property string|null $prepay_id
 * @property string|null $paid_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $inspector
 * @property-read \App\Models\Service $service
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereDetectionResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereInspectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder wherePrepayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceOrder whereUserId($value)
 * @mixin \Eloquent
 */
class ServiceOrder extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function inspector()
    {
        return $this->belongsTo('App\Models\User', 'inspector_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}