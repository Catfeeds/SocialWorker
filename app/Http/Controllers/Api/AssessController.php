<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/6/13
 * Time: 15:51
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\AssessResource;
use App\Models\Assess;
use Illuminate\Http\Request;

class AssessController extends ApiController
{
    public function index(Request $request)
    {
        return $this->success(AssessResource::collection(
            Assess::when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })->get()
        ));
    }
}