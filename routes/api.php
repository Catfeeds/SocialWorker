<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    // 用户注册
    Route::post('/register', 'TokenController@register')->name('tokens.register');
    // 用户登录
    Route::post('/login', 'TokenController@login')->name('tokens.login');
    // 刷新token
    Route::post('/refresh', 'TokenController@refresh')->name('tokens.refresh');

    // 获取自己的资料
    Route::get('/users/self', 'UserController@self')->name('users.self');

    Route::get('/invite_info/{id}', 'GroupController@inviteInfo')->name('groups.inviteInfo');

    Route::get('/users/self/groups', 'UserController@groups')->name('users.groups');
    Route::get('/users/self/asset', 'UserController@asset')->name('users.asset');
    Route::get('/users/self/receivable', 'UserController@receivable')->name('users.receivable');
    Route::post('/equipment/bind', 'EquipmentController@bind');

    Route::apiResource('groups', 'GroupController')
        ->only(['show']);

    Route::apiResource('receivables', 'ReceivableController')
        ->only(['store']);

    Route::apiResource('cashes', 'CashController')
        ->only(['store']);

    Route::get('/invitation_codes/{id}', 'InvitationCodeController@show')->name('invitation_codes.show');

    Route::apiResource('equipment_categories', 'EquipmentCategoryController')
        ->only(['index']);

    Route::apiResource('equipment', 'EquipmentController')
        ->only(['index']);

    Route::middleware('role:super')->group(function () {

        Route::apiResource('equipment_categories', 'EquipmentCategoryController')
            ->only(['store', 'destroy']);

        Route::apiResource('equipment', 'EquipmentController')
            ->only(['store']);
    });


    Route::post('/test', function () {

        return createGuid();

        return \Illuminate\Support\Facades\Schema::getColumnListing((new \App\Models\User())->getTable());

        Cache::forget('wx_access_token');
        return;

//        return \App\Models\User::findOrFail(7)->assetRecords;

        return (new \App\Http\Controllers\Api\UserController())->asset();

        \App\Models\User::create([
            'nickname' => 'nickname',
            'avatar' => 'avatar',
            'sex' => 0
        ]);
    });
});