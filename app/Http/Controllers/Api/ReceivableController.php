<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/17
 * Time: 16:10
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\StoreReceivable;
use App\Models\Receivable;
use App\Services\Tokens\TokenFactory;

class ReceivableController extends ApiController
{
    public function store(StoreReceivable $request)
    {
        Receivable::updateOrCreate(
            ['user_id' => TokenFactory::getCurrentUID()],
            [
                'name' => $request->post('name'),
                'id_card_no' => $request->post('id_card_no'),
                'bank' => $request->post('bank'),
                'account' => $request->post('account')
            ]
        );

        return $this->created();
    }
}