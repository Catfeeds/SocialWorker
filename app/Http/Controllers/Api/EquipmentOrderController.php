<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/22
 * Time: 17:43
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\CrowdFundingOrderResource;
use App\Http\Resources\EquipmentOrderCollection;
use App\Http\Resources\EquipmentOrderResource;
use App\Http\Resources\UserResource;
use App\Models\CrowdFundingOrder;
use App\Models\EquipmentOrder;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EquipmentOrderController extends ApiController
{
    public function index(Request $request)
    {
        $equipmentOrder = (new EquipmentOrder())
            ->when($request->order_no, function ($query) use ($request) {
                $query->where('order_no', $request->order_no);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->date, function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
            ->paginate(Input::get('limit') ?: 20);

        return $this->success(new EquipmentOrderCollection($equipmentOrder));
    }

    public function show(EquipmentOrder $equipmentOrder)
    {
        if (in_array('super', TokenFactory::getCurrentRoles()))
            return $this->success(new EquipmentOrderResource($equipmentOrder));

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