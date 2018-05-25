<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 10:08
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\StoreAddress;
use App\Http\Resources\UserAddressResource;
use App\Models\Address;
use App\Models\User;
use App\Services\Tokens\TokenFactory;

class AddressController extends ApiController
{
    public function index()
    {
        return $this->success(new UserAddressResource(TokenFactory::getCurrentUser()->address));
    }

    public function show($id)
    {
        $address = User::findOrFail($id)->address;

        return $this->success($address ? new UserAddressResource($address) : null);
    }

    public function store(StoreAddress $request)
    {
        $uid = TokenFactory::getCurrentUID();

        Address::updateOrCreate(
            ['user_id' => $uid],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'city' => $request->city,
                'detail' => $request->detail
            ]
        );

        return $this->message('ok.');
    }
}