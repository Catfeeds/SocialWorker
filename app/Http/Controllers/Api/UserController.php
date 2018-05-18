<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\ReceivableResource;
use App\Http\Resources\UserAssetResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserGroupResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(new UserCollection(User::paginate(Input::get('limit') ?: 10)));
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
    public function update(Request $request, $id)
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
        return $this->success(new UserResource(TokenFactory::getCurrentUser()));
    }

    public function groups()
    {
        return $this->success(UserGroupResource::collection(TokenFactory::getCurrentUser()->selfGroups));
    }

    public function asset()
    {
        return $this->success(new UserAssetResource(TokenFactory::getCurrentUser()->asset));
    }

    public function receivable()
    {
        $receivable = TokenFactory::getCurrentUser()->receivable;

        if (!$receivable) return $this->success(null);

        return $this->success(new ReceivableResource($receivable));
    }
}
