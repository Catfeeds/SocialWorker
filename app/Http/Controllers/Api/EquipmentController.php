<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/18
 * Time: 14:49
 */

namespace App\Http\Controllers\Api;


use App\Exceptions\BaseException;
use App\Http\Requests\BindEquipment;
use App\Http\Resources\EquipmentCollection;
use App\Models\Equipment;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EquipmentController extends ApiController
{
    public function index()
    {
        return $this->success(new EquipmentCollection(Equipment::paginate(Input::get('limit') ?: 20)));
    }

    public function store(Request $request)
    {
        $categoryId = $request->post('category_id');
        $count = $request->post('count');

        $data = [];
        for ($i = 1; $i <= $count; $i++) {
            array_push($data, [
                'category_id' => $categoryId,
                'serial_no' => createGuid()
            ]);
        }

        Equipment::saveAll($data);

        return $this->created();
    }

    /**
     * 绑定设备
     *
     * @param BindEquipment $request
     * @return mixed
     * @throws BaseException
     * @throws \App\Exceptions\TokenException
     */
    public function bind(BindEquipment $request)
    {
        $equipment = Equipment::where('serial_no', $request->post('serial_no'))->first();

        if ($equipment->status == 1) throw new BaseException('该设备已被绑定');

        $equipment->update([
            'status' => 1,
            'user_id' => TokenFactory::getCurrentUID()
        ]);

        return $this->message('绑定成功');
    }

    /**
     * 解绑设备
     *
     * @param BindEquipment $request
     * @return mixed
     * @throws BaseException
     * @throws \App\Exceptions\ForbiddenException
     * @throws \App\Exceptions\TokenException
     */
    public function unbind(BindEquipment $request)
    {
        $serialNo = $request->post('serial_no');
        $equipment = Equipment::where('serial_no', $serialNo)->first();

        if ($equipment->status == 0) throw new BaseException('该设备未绑定');

        TokenFactory::needSelfOrRole($equipment->user_id);

        $equipment->update([
            'status' => 0,
            'user_id' => null
        ]);

        return $this->message('解绑成功');
    }
}