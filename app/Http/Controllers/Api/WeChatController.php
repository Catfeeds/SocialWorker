<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/21
 * Time: 18:11
 */

namespace App\Http\Controllers\Api;

use App\Enum\PayTypeEnum;
use App\Enum\ServiceOrderStatusEnum;
use App\Exceptions\BaseException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\CrowdFundingOrder;
use App\Models\EquipmentOrder;
use App\Models\ServiceOrder;
use App\Services\AssetService;
use App\Services\Tokens\TokenFactory;
use Carbon\Carbon;
use EasyWeChat;
use Illuminate\Http\Request;


class WeChatController extends ApiController
{
    /**
     * 获取支付信息
     *
     * @param Request $request
     * @return mixed|void
     * @throws BaseException
     * @throws ResourceNotFoundException
     */
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
            case PayTypeEnum::FUNDING:
                return $this->fundingPay($orderNO);
            default:
                throw new BaseException('订单类型错误');
        }
    }

    /**
     * 申请设备支付订单
     *
     * @param $orderNO
     * @return mixed
     * @throws BaseException
     * @throws ResourceNotFoundException
     * @throws \App\Exceptions\TokenException
     */
    public function equipmentPay($orderNO)
    {
        $payment = EasyWeChat::payment();

        $order = EquipmentOrder::where('order_no', $orderNO)->first();

        if (!$order) throw new ResourceNotFoundException('订单不存在');
        if ($order->status == 1) throw new BaseException('订单已支付');
        if (!TokenFactory::isValidOperate($order->user_id)) throw new BaseException('订单与用户不匹配');

        $result = $payment->order->unify([
            'body' => '社工之家',
            'out_trade_no' => $orderNO,
            'total_fee' => ($order->price - $order->raise) * 100,
            'trade_type' => 'JSAPI',
            'openid' => TokenFactory::getCurrentTokenVar('identifier'),
            'notify_url' => config('wechat.payment.default.notify_url') . '/equipment'
        ]);

        $this->validateWxResult($result);

        $order->prepay_id = $result['prepay_id'];
        $order->save();

        return $this->success($payment->jssdk->sdkConfig($result['prepay_id']));
    }

    /**
     * 申请设备支付回调
     *
     * @return mixed
     */
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
                    // 消费返利
                    AssetService::income($order->user_id, 'consume', $order->price);

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

    /**
     * 购买服务支付订单
     *
     * @param $orderNO
     * @return mixed
     * @throws BaseException
     * @throws ResourceNotFoundException
     * @throws \App\Exceptions\TokenException
     */
    public function servicePay($orderNO)
    {
        $payment = EasyWeChat::payment();

        $order = ServiceOrder::where('order_no', $orderNO)->first();

        if (!$order) throw new ResourceNotFoundException('订单不存在');
        if ($order->status !== ServiceOrderStatusEnum::UNPAID) throw new BaseException('订单已支付');
        if (!TokenFactory::isValidOperate($order->user_id)) throw new BaseException('订单与用户不匹配');

        $result = $payment->order->unify([
            'body' => '社工之家',
            'out_trade_no' => $orderNO,
            'total_fee' => $order->price * 100,
            'trade_type' => 'JSAPI',
            'openid' => TokenFactory::getCurrentTokenVar('identifier'),
            'notify_url' => config('wechat.payment.default.notify_url') . '/service'
        ]);

        $this->validateWxResult($result);

        $order->prepay_id = $result['prepay_id'];
        $order->save();

        return $this->success($payment->jssdk->sdkConfig($result['prepay_id']));
    }

    /**
     * 购买服务支付回调
     *
     * @return mixed
     */
    public function serviceNotify()
    {
        $payment = EasyWeChat::payment();

        $response = $payment->handlePaidNotify(function ($message, $fail) {
            if ($message['return_code'] !== 'SUCCESS') return $fail('通信失败，请稍后再通知');

            \DB::beginTransaction();
            try {
                $order = ServiceOrder::where('order_no', $message['out_trade_no'])->sharedLock()->first();
                if (!$order || $order->status !== ServiceOrderStatusEnum::UNPAID) return true;

                if (array_get($message, 'result_code') === 'SUCCESS') {
                    // 消费返利
                    AssetService::income($order->user_id, 'consume', $order->price);
                    // 为提供服务用户增加资产
                    AssetService::income($order->inspector_id, 'service', $order->price);

                    $order->status = ServiceOrderStatusEnum::CONFIRM;
                    $order->paid_at = Carbon::now();
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

    /**
     * 众筹支付订单
     *
     * @param $orderNO
     * @return mixed
     * @throws BaseException
     * @throws ResourceNotFoundException
     * @throws \App\Exceptions\TokenException
     */
    public function fundingPay($orderNO)
    {
        $payment = EasyWeChat::payment();

        $order = CrowdFundingOrder::where('order_no', $orderNO)->first();

        if (!$order) throw new ResourceNotFoundException('订单不存在');
        if ($order->status !== 0) throw new BaseException('订单已支付');
        if ($order->equipmentOrder->status !== 0) throw new BaseException('订单已支付');
        if ($order->equipmentOrder->price - $order->equipmentOrder->raise < 2.9) throw new BaseException('超出订单剩余可支付额度');
        if (!TokenFactory::isValidOperate($order->user_id)) throw new BaseException('订单与用户不匹配');

        $result = $payment->order->unify([
            'body' => '社工之家',
            'out_trade_no' => $orderNO,
            'total_fee' => $order->price * 100,
            'trade_type' => 'JSAPI',
            'openid' => TokenFactory::getCurrentTokenVar('identifier'),
            'notify_url' => config('wechat.payment.default.notify_url') . '/funding'
        ]);

        $this->validateWxResult($result);

        $order->prepay_id = $result['prepay_id'];
        $order->save();

        return $this->success($payment->jssdk->sdkConfig($result['prepay_id']));
    }

    /**
     * 众筹支付回调
     *
     * @return mixed
     */
    public function fundingNotify()
    {
        $payment = EasyWeChat::payment();

        $response = $payment->handlePaidNotify(function ($message, $fail) {
            if ($message['return_code'] !== 'SUCCESS') return $fail('通信失败，请稍后再通知');

            \DB::beginTransaction();
            try {
                $order = CrowdFundingOrder::where('order_no', $message['out_trade_no'])->sharedLock()->first();
                if (!$order || $order->status !== 0) return true;

                if (array_get($message, 'result_code') === 'SUCCESS') {
                    // 消费返利
                    AssetService::income($order->user_id, 'consume', $order->price);

                    $order->equipmentOrder()->increment('raise', $order->price);
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