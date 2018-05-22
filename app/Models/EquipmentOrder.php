<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/22
 * Time: 16:10
 */

namespace App\Models;


use App\Services\Tokens\TokenFactory;

class EquipmentOrder extends Model
{
    protected $guarded = [];

    public static function generate($ids)
    {
        $products = EquipmentCategory::whereIn('id', $ids)->get(['name', 'price']);

        $totalPrice = $products->sum('price');

        $order = self::create([
            'user_id' => TokenFactory::getCurrentUID(),
            'order_no' => makeOrderNo(),
            'price' => $totalPrice,
            'snap_content' => $products
        ]);

        return $order;
    }
}