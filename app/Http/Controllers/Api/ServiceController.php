<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/23
 * Time: 11:43
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\ServiceCollection;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ServiceController extends ApiController
{
    public function index()
    {
        return $this->success(new ServiceCollection(Service::paginate(Input::get('limit') ?: 20)));
    }

    public function store(Request $request)
    {
        Service::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return $this->created();
    }
}