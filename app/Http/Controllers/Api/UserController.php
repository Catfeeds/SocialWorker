<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\UpdateUser;
use App\Http\Resources\AssessResource;
use App\Http\Resources\EquipmentOrderResource;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\ReceivableResource;
use App\Http\Resources\ServiceOrderCollection;
use App\Http\Resources\ServiceOrderResource;
use App\Http\Resources\UserAddressResource;
use App\Http\Resources\UserAssetResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserGroupResource;
use App\Http\Resources\UserResource;
use App\Models\Assess;
use App\Models\Asset;
use App\Models\Group;
use App\Models\User;
use App\Services\Tokens\TokenFactory;
use App\Services\WXBizDataCrypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = (new User())
            ->where('is_bind_account', 0)
            ->when($request->nickname, function ($query) use ($request) {
                $query->where('nickname', 'like', '%' . $request->nickname . '%');
            })
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->phone, function ($query) use ($request) {
                $query->where('phone', 'like', '%' . $request->phone . '%');
            })
            ->paginate(Input::get('limit') ?: 20);

        return $this->success(new UserCollection($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->success(new UserResource(User::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 查看自己的资料
     *
     * @return mixed
     * @throws \App\Exceptions\TokenException
     */
    public function self()
    {
        return $this->success((new UserResource(TokenFactory::getCurrentUser()))->hide(['account', 'email', 'is_bind_phone', 'is_bind_email', 'is_bind_account', 'is_bind_wx']));
    }

    public function selfUpdate(UpdateUser $request)
    {
        TokenFactory::getCurrentUser()->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'education' => $request->education,
            'age' => $request->age,
            'sex' => $request->sex,
            'wants' => $request->wants
        ]);

        return $this->message('ok.');
    }

    public function isBindPhone()
    {
        return $this->success(TokenFactory::getCurrentUser()->phone != null);
    }

    /**
     * 绑定用户手机号
     *
     * @param Request $request
     * @return string
     * @throws \App\Exceptions\BaseException
     */
    public function bindPhone(Request $request)
    {
        $pc = new WXBizDataCrypt();
        $data = $pc->decryptData($request->encryptedData, $request->iv);

        TokenFactory::getCurrentUser()->update([
            'phone' => $data['purePhoneNumber']
        ]);

        return $this->success('绑定成功');
    }

    public function groups()
    {
        return $this->success(UserGroupResource::collection(TokenFactory::getCurrentUser()->selfGroups));
    }

    public function equipment()
    {
        return $this->success(EquipmentResource::collection(TokenFactory::getCurrentUser()->bindingsEquipment));
    }

    public function asset()
    {
        return $this->success(new UserAssetResource(TokenFactory::getCurrentUser()->asset));
    }

    public function receivable()
    {
        return $this->success(new ReceivableResource(TokenFactory::getCurrentUser()->receivable));
    }

    public function checks()
    {
        return $this->success(
            ServiceOrderResource::collection(TokenFactory::getCurrentUser()
                ->checks()
                ->where('status', '>', 1)
                ->get()
            )
        );
    }

    public function services()
    {
        return $this->success(
            ServiceOrderResource::collection(TokenFactory::getCurrentUser()
                ->services()
                ->where('status', '>', 1)
                ->get()
            )
        );
    }

    public function equipmentOrders()
    {
        return $this->success(EquipmentOrderResource::collection(
            TokenFactory::getCurrentUser()
                ->equipmentOrders()
                ->where('type', 2)
                ->get()
        ));
    }

    public function address()
    {
        return $this->success(new UserAddressResource(TokenFactory::getCurrentUser()->address));
    }

    public function assesses(Request $request)
    {
        return $this->success(AssessResource::collection(
            TokenFactory::getCurrentUser()
                ->assesses()
                ->when($request->type, function ($query) use ($request) {
                    $query->where('type', $request->type);
                })->get()
        ));
    }

    public function saveAssesses(Request $request)
    {
        $currentAssesses = TokenFactory::getCurrentUser()
            ->assesses()
            ->where('type', '<>', $request->type)
            ->pluck('id')
            ->toArray();

        if (!$request->ids)
            TokenFactory::getCurrentUser()->assesses()->sync($currentAssesses);
        else {
            array_push($currentAssesses, ...$request->ids);
            TokenFactory::getCurrentUser()->assesses()->sync($currentAssesses);
        }
        return $this->message('保存成功');
    }

    public function health()
    {
        return $this->success([
            'indicator' => [
                ['name' => '个人病史', 'max' => 100, 'value' => Assess::getScorePercent(1)],
                ['name' => '从事职业', 'max' => 100, 'value' => Assess::getScorePercent(2)],
                ['name' => '家族遗传', 'max' => 100, 'value' => Assess::getScorePercent(3)],
                ['name' => '生活状态', 'max' => 100, 'value' => Assess::getScorePercent(4)],
                ['name' => '日常体征', 'max' => 100, 'value' => Assess::getScorePercent(5)]
            ],
            'total' => Assess::getScorePercent() . '%',
            'result' => Assess::getTotalResult()
        ]);
    }

    public function friends($uid)
    {
        $friends = [];
        $this->getFriends($uid, $friends);

        return $friends;
    }

    public function getFriends($uid, &$friends, $level = 1)
    {
        foreach (User::findOrFail($uid)->selfGroups as $selfGroup) {
            foreach ($selfGroup->users as $user) {
                array_push($friends, [
                    'id' => $user->id,
                    'nickname' => $user->nickname,
                    'phone' => $user->phone ?: '-',
                    'level' => $level,
                    'created_at' => (string)$user->created_at
                ]);
                $this->getFriends($user->id, $friends, $level + 1);
            }
        }
    }
}
