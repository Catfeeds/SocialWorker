<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/21
 * Time: 18:11
 */

namespace App\Http\Controllers\Api;

use App\Enum\PayTypeEnum;
use App\Exceptions\BaseException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\EquipmentOrder;
use App\Services\Tokens\TokenFactory;
use EasyWeChat;
use Illuminate\Http\Request;


class WeChatController extends ApiController
{
    public function pay(Request $request)
    {
        $type = $request->post('type');
        $orderNO = $request->post('order_no');

        switch ($type) {
            case PayTypeEnum::EQUIPMENT:
                return $this->equipmentPay($orderNO);
            case PayTypeEnum::SERVICE:
                return $this->servicePay($orderNO);
            case PayTypeEnum::INTEGRAL:
                return $this->integralPay($orderNO);
            default:
                throw new BaseException('订单类型错误');
        }
    }

    public function equipmentPay($orderNO)
    {
        $payment = EasyWeChat::payment();

        $order = EquipmentOrder::where('order_no', $orderNO)->first();

        if (!$order) throw new ResourceNotFoundException('订单不存在');
        if ($order->status == 1) throw new BaseException('订单已支付');

        $result = $payment->order->unify([
            'body' => '天天血压',
            'out_trade_no' => $orderNO,
            'total_fee' => ($order->price - $order->raise) * 100,
            'trade_type' => 'JSAPI',
            'openid' => TokenFactory::getCurrentTokenVar('identifier'),
            'notify_url' => config('wechat.payment.default.notify_url') . '/equipment'
        ]);

        $this->validateWxResult($result);

        $order->prepay_id = $result['prepay_id'];
        $order->save();

        return $this->success($payment->jssdk->appConfig($result['prepay_id']));
    }

    public function equipmentNotify()
    {
        $payment = EasyWeChat::payment();

        $response = $payment->handlePaidNotify(function ($message, $fail) {
            if ($message['return_code'] !== 'SUCCESS') return $fail('通信失败，请稍后再通知');

            \DB::beginTransaction();
            try {
                $order = EquipmentOrder::where('order_no', $message['out_trade_no'])->sharedLock()->first();
                if (!$order || $order->status == 1) return true;

                if (array_get($message, 'result_code') === 'SUCCESS') {
                    $order->status = 1;
                    $order->save();
                }

                \DB::commit();

                return true;
            } catch (\Exception $exception) {
                \DB::rollBack();
                return $fail('请稍后通知');
            }
        });

        return $response;
    }

    public function servicePay($orderNO)
    {

    }

    public function integralPay($orderNO)
    {

    }

    public function validateWxResult($result)
    {
        if ($result['return_code'] != 'SUCCESS' || $result['result_code'] != 'SUCCESS') {
            \Log::error($result);
            \Log::error('获取预支付订单失败');

            throw new BaseException('获取预支付订单失败');
        }
    }
}