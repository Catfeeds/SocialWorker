<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/18
 * Time: 11:20
 */

namespace App\Models;


/**
 * App\Models\Equipment
 *
 * @mixin \Eloquent
 * @property-read \App\Models\EquipmentCategory $category
 * @property int $id
 * @property int $equipment_category_id
 * @property string $serial_no
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereEquipmentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereUpdatedAt($value)
 * @property int $status 0未绑定 1已绑定
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereUserId($value)
 * @property int $category_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereCategoryId($value)
 */
class Equipment extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Models\EquipmentCategory', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}