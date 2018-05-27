<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/22
 * Time: 17:43
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\CrowdFundingOrderResource;
use App\Http\Resources\EquipmentOrderResource;
use App\Http\Resources\UserResource;
use App\Models\CrowdFundingOrder;
use App\Models\EquipmentOrder;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;

class EquipmentOrderController extends ApiController
{
    public function show(EquipmentOrder $equipmentOrder)
    {
        return $this->success([
            'id' => $equipmentOrder->id,
            'user' => (new UserResource($equipmentOrder->user))->show(['nickname', 'avatar']),
            'group_id' => ($equipmentOrder->user->selfGroups)[0]->id,
            'surplus' => $equipmentOrder->price - $equipmentOrder->raise,
            'guarantee' => CrowdFundingOrderResource::collection(
                $equipmentOrder->crowdFundingOrders()
                    ->where('status', 1)
                    ->paginate(6)
            ),
            'guarantee_count' => $equipmentOrder->crowdFundingOrders()
                ->where('status', 1)
                ->count()
        ]);
    }

    public function store(Request $request)
    {
        return $this->success(new EquipmentOrderResource(
            EquipmentOrder::generate($request->post('ids'), $request->post('type') ?: 1)
        ));
    }

    public function isPaid($id)
    {
        $paid = CrowdFundingOrder::where('equipment_order_id', $id)
            ->where('user_id', TokenFactory::getCurrentUID())
            ->where('status', 1)
            ->exists();

        return $this->success($paid);
    }
}