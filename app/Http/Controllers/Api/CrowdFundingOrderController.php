<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/25
 * Time: 17:24
 */

namespace App\Http\Controllers\Api;


use App\Exceptions\BaseException;
use App\Http\Resources\CrowdFundingOrderResource;
use App\Models\CrowdFundingOrder;
use App\Models\EquipmentOrder;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;

class CrowdFundingOrderController extends ApiController
{
    /**
     * 创建众筹订单
     *
     * @param Request $request
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $equipmentOrder = EquipmentOrder::where('id', $request->order_id)
                ->sharedLock()
                ->first();

            if ($equipmentOrder->status == 1)
                throw new BaseException('该订单已支付');
            if ($equipmentOrder->price - $equipmentOrder->raise < 2.9)
                throw new BaseException('超出订单剩余可支付额度');
            if ($equipmentOrder->user_id == TokenFactory::getCurrentUID())
                throw new BaseException('不能为自己支付');

            $order = CrowdFundingOrder::create([
                'equipment_order_id' => $request->order_id,
                'user_id' => TokenFactory::getCurrentUID(),
                'order_no' => makeOrderNo(),
                'price' => 2.9
            ]);

            \DB::commit();

            return $this->success(new CrowdFundingOrderResource($order));
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw $exception;
        }
    }
}