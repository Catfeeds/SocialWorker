<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/18
 * Time: 14:49
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\EquipmentCollection;
use App\Models\Equipment;
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

    public function bind(Request $request)
    {
        $serialNo = $request->post('serial_no');
    }
}