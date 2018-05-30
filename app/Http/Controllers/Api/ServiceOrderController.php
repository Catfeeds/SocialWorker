<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 14:02
 */

namespace App\Http\Controllers\Api;


use App\Enum\ServiceOrderStatusEnum;
use App\Exceptions\BaseException;
use App\Http\Resources\ServiceOrderResource;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Services\AssetService;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;

class ServiceOrderController extends ApiController
{
    public function store(Request $request)
    {
        $uid = TokenFactory::getCurrentUID();
        if ($uid == $request->inspector_id) throw new BaseException('不能为自己提供服务');

        $order = ServiceOrder::create([
            'user_id' => $uid,
            'service_id' => $request->service_id,
            'inspector_id' => $request->inspector_id,
            'price' => Service::findOrFail($request->service_id)->price,
            'order_no' => makeOrderNo(),
            'status' => ServiceOrderStatusEnum::UNPAID
        ]);

        if ($request->cash) $order->update(['status' => ServiceOrderStatusEnum::PAYED]);

        return $this->success(new ServiceOrderResource($order));
    }

    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        if (!TokenFactory::isValidOperate($serviceOrder->inspector_id))
            throw new BaseException('不能操作他人订单');

        if ($serviceOrder->status == ServiceOrderStatusEnum::UNPAID)
            throw new BaseException('订单未支付，不能操作');

        $serviceOrder->status = ServiceOrderStatusEnum::CONFIRM;

        if ($request->detection_result){
            $serviceOrder->detection_result = $request->detection_result;
            $serviceOrder->status = ServiceOrderStatusEnum::COMPLETED;

            AssetService::transfer(TokenFactory::getCurrentUID(), 'beinvite');
        }

        $serviceOrder->save();

        return $this->message('更新成功');
    }
}