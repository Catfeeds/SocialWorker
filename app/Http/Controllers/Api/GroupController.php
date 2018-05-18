<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/14
 * Time: 16:18
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\GroupResource;
use App\Models\Group;

class GroupController extends ApiController
{
    public function show(Group $group)
    {
        return $this->success(new GroupResource($group));
    }
}