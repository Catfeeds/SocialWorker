<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/18
 * Time: 14:49
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\EquipmentCategoryResource;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;

class EquipmentCategoryController extends ApiController
{
    public function index()
    {
        return $this->success(EquipmentCategoryResource::collection(EquipmentCategory::all()));
    }

    public function store(Request $request)
    {
        EquipmentCategory::create([
            'name' => $request->post('name'),
            'price' => $request->post('price')
        ]);

        return $this->created();
    }

    public function destroy(EquipmentCategory $equipmentCategory)
    {
        $equipmentCategory->delete();

        return $this->message('删除成功');
    }
}