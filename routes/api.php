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
    Route::get('/users/self/equipment', 'UserController@equipment')->name('users.equipment');

    Route::apiResource('groups', 'GroupController')
        ->only(['show']);

    Route::apiResource('receivables', 'ReceivableController')
        ->only(['store']);

    Route::apiResource('cashes', 'CashController')
        ->only(['store']);

    Route::get('/invitation_codes/{id}', 'InvitationCodeController@show')->name('invitation_codes.show');
    Route::get('/service_codes/{id}', 'ServiceCodeController@show')->name('service_codes.show');

    Route::apiResource('equipment_categories', 'EquipmentCategoryController')
        ->only(['index']);

    Route::apiResource('equipment', 'EquipmentController')
        ->only(['index']);

    Route::apiResource('equipment_orders', 'EquipmentOrderController')
        ->only(['store']);

    Route::put('/equipment/bind', 'EquipmentController@bind')->name('equipment.bind');
    Route::put('/equipment/unbind', 'EquipmentController@unbind')->name('equipment.unbind');

    Route::middleware('role:super')->group(function () {

        Route::apiResource('equipment_categories', 'EquipmentCategoryController')
            ->only(['store', 'destroy']);

        Route::apiResource('equipment', 'EquipmentController')
            ->only(['store']);
    });

    Route::post('/payment/wechat_pay', 'WeChatController@pay');
    Route::post('/payment/wechat_notify/equipment', 'WeChatController@equipmentNotify');

    Route::get('/test', function () {
        $payment = EasyWeChat::payment();
        return $payment->order->queryByOutTradeNumber('A522028116474344');
    });
});