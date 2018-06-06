<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/18
 * Time: 14:49
 */

namespace App\Http\Controllers\Api;


use App\Exceptions\BaseException;
use App\Exports\EquipmentExport;
use App\Http\Requests\BindEquipment;
use App\Http\Resources\EquipmentCollection;
use App\Models\Equipment;
use App\Services\AssetService;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class EquipmentController extends ApiController
{
    public function index(Request $request)
    {
        $equipment = (new Equipment())
            ->when($request->serial_no, function ($query) use ($request) {
                $query->where('serial_no', 'like', '%' . $request->serial_no . '%');
            })
            ->when($request->phone, function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('phone', 'like', '%' . $request->phone . '%');
                });
            })
            ->when($request->status != '', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->paginate(Input::get('limit') ?: 20);

        return $this->success(new EquipmentCollection($equipment));
    }

    public function store(Request $request)
    {
        $categoryId = $request->post('category_id');
        $count = $request->post('count');
        $prefix = $request->post('prefix');

//        $data = [];
//        for ($i = 1; $i <= $count; $i++) {
//            array_push($data, [
//                'category_id' => $categoryId,
//                'serial_no' => makeSerialNo($prefix, $i)
//            ]);
//        }
//        Equipment::saveAll($data);

        $arr = [];
        for ($i = 1; $i <= $count; $i++)
            array_push($arr, $this->makeSerialNo($prefix, $categoryId, $arr));

        $data = [];
        foreach ($arr as $value) {
            array_push($data, [
                'category_id' => $categoryId,
                'serial_no' => $value
            ]);
        }
        Equipment::saveAll($data);

        return $this->created();
    }

    public function makeSerialNo($prefix, $categoryId, $arr)
    {
        $serialNo = $prefix . '-' . ($categoryId - 1) . 0 . '-' . getRandChar(8, true);
        if (in_array($serialNo, $arr) || Equipment::where('serial_no', $serialNo)->exists())
            $serialNo = $this->makeSerialNo($prefix, $categoryId, $arr);
        return $serialNo;
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
        $serialNo = $request->post('serial_no');
        if (substr($serialNo, 3, 1) != '-') {
            $serialNo = substr_replace($serialNo, '-', 3, 0);
        }
        if (substr($serialNo, 6, 1) != '-') {
            $serialNo = substr_replace($serialNo, '-', 6, 0);
        }

        $equipment = Equipment::where('serial_no', $serialNo)->first();

        if (!$equipment) throw new BaseException('设备序列号错误');
        if ($equipment->status == 1) throw new BaseException('该设备已被绑定');

        $equipment->update([
            'status' => 1,
            'user_id' => TokenFactory::getCurrentUID()
        ]);

        AssetService::income(TokenFactory::getCurrentUID(), 'buy', $request->post('serial_no'));

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

    public function export()
    {
        $export = Excel::download(new EquipmentExport(), 'equipment.xlsx');

        Equipment::where('export', 0)
            ->update(['export' => 1]);

        return $export;
    }
}