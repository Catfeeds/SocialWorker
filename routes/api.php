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
    Route::put('/users/self', 'UserController@selfUpdate');

    Route::get('/invite_info/{id}', 'GroupController@inviteInfo')->name('groups.inviteInfo');

    Route::get('/group_id/{id}', 'GroupController@getIdByUserId');

    Route::get('/equipment_orders/is_paid/{id}', 'EquipmentOrderController@isPaid');

    Route::get('/users/self/groups', 'UserController@groups')->name('users.groups');
    Route::get('/users/self/asset', 'UserController@asset')->name('users.asset');
    Route::get('/users/self/receivable', 'UserController@receivable')->name('users.receivable');
    Route::get('/users/self/equipment', 'UserController@equipment')->name('users.equipment');
    Route::get('/users/self/checks', 'UserController@checks');
    Route::get('/users/self/services', 'UserController@services');
    Route::get('/users/self/address', 'UserController@address');

    Route::get('/invitation_codes/{id}', 'InvitationCodeController@show')->name('invitation_codes.show');
    Route::get('/service_codes/{id}', 'ServiceCodeController@show')->name('service_codes.show');
    Route::get('/funding_codes/{id}', 'EquipmentOrderCodeController@show')->name('equipment_order_codes.show');

    Route::put('/equipment/bind', 'EquipmentController@bind')->name('equipment.bind');
    Route::put('/equipment/unbind', 'EquipmentController@unbind')->name('equipment.unbind');

    Route::post('/payment/wechat_pay', 'WeChatController@pay');
    Route::post('/payment/wechat_notify/equipment', 'WeChatController@equipmentNotify');
    Route::post('/payment/wechat_notify/service', 'WeChatController@serviceNotify');

    Route::apiResource('addresses', 'AddressController')
        ->only(['store']);

    Route::apiResource('groups', 'GroupController')
        ->only(['show']);

    Route::apiResource('receivables', 'ReceivableController')
        ->only(['store']);

    Route::apiResource('cashes', 'CashController')
        ->only(['store']);

    Route::apiResource('equipment_categories', 'EquipmentCategoryController')
        ->only(['index']);

    Route::apiResource('equipment', 'EquipmentController')
        ->only(['index']);

    Route::apiResource('equipment_orders', 'EquipmentOrderController')
        ->only(['store', 'show']);

    Route::apiResource('services', 'ServiceController')
        ->only(['index']);

    Route::apiResource('service_orders', 'ServiceOrderController')
        ->only(['store', 'update']);

    Route::apiResource('funding_orders', 'CrowdFundingOrderController')
        ->only(['store']);


    /**
     * 需超级管理员权限
     */
    Route::middleware('role:super')->group(function () {

        Route::apiResource('users', 'UserController')
            ->only(['index', 'show']);

        Route::apiResource('addresses', 'AddressController')
            ->only(['show']);

        Route::apiResource('equipment_categories', 'EquipmentCategoryController')
            ->only(['store', 'destroy']);

        Route::apiResource('equipment', 'EquipmentController')
            ->only(['store']);

        Route::apiResource('services', 'ServiceController')
            ->only(['store']);

        Route::apiResource('cashes', 'CashController')
            ->only(['index', 'update']);

        Route::get('/cashes/export', 'CashController@export');
        Route::get('/equipment/export', 'EquipmentController@export');
    });


    Route::get('/test', function () {

        return (new \App\Models\User())->friends(1);
        $payment = EasyWeChat::payment();
        return $payment->order->queryByOutTradeNumber('A522028116474344');
    });
});