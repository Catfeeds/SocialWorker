<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/17
 * Time: 17:46
 */

namespace App\Http\Controllers\Api;


use App\Exceptions\ResourceStoreException;
use App\Http\Requests\StoreCash;
use App\Models\Cash;
use App\Services\Tokens\TokenFactory;
use DB;
use Exception;

class CashController extends ApiController
{
    /**
     * 提现
     *
     * @param StoreCash $request
     * @return mixed
     * @throws ResourceStoreException
     * @throws \Throwable
     */
    public function store(StoreCash $request)
    {
        $number = $request->post('number');
        $tax = round(taxRate($number));

        try {
            DB::transaction(function () use ($number, $tax) {
                Cash::create([
                    'user_id' => TokenFactory::getCurrentUID(),
                    'number' => $number,
                    'tax' => $tax
                ]);

                TokenFactory::getCurrentUser()->asset()->decrement('available', $number);
            });
        } catch (Exception $exception) {
            throw new ResourceStoreException('提现失败，请重试');
        }

        return $this->created();
    }
}