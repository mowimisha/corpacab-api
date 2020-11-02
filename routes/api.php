<?php


Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::post('register-driver', 'RegisterController@register_driver');
    Route::post('register-owner', 'RegisterController@register_owner');

    Route::get('me', 'MeController');
});


Route::group(['prefix' => 'v1', ['middleware' => 'jwt.auth']], function () {

    Route::apiResource('users', 'api\UserController');
    Route::apiResource('drivers', 'api\DriverController');
    Route::apiResource('owners', 'api\OwnerController');
    Route::apiResource('vehicles', 'api\VehicleController');
    Route::apiResource('services', 'api\ServiceController');
    Route::apiResource('documents', 'api\DocumentController');
    Route::apiResource('expenses', 'api\ExpenseController');
    Route::apiResource('expenditures', 'api\ExpenditureController');


    Route::get('all-payments', 'api\MpesaController@driver_payments');
    Route::get('show-payment/{id}', 'api\MpesaController@show_payment');
    Route::get('account-balance', 'api\MpesaController@accountBalance');
    Route::get('make-payment', 'api\MpesaController@makePayment');
    Route::get('driver-pay2', 'api\MpesaController@STKPush1000');
    Route::get('driver-pay3', 'api\MpesaController@STKPush1200');
    Route::get('driver-pay4', 'api\MpesaController@STKPush1300');
    Route::get('driver-pay5', 'api\MpesaController@STKPush1500');
    Route::get('driver-pay6', 'api\MpesaController@STKPush1600');
    Route::get('driver-pay7', 'api\MpesaController@STKPush1700');
    Route::get('driver-pay8', 'api\MpesaController@STKPush1800');
    Route::get('driver-pay9', 'api\MpesaController@STKPush2000');
    Route::get('driver-pay10', 'api\MpesaController@STKPush2500');
    Route::get('driver-pay11', 'api\MpesaController@STKPush3000');
    Route::get('driver-pay12', 'api\MpesaController@STKPush3500');
    Route::get('driver-pay13', 'api\MpesaController@STKPush4000');
    Route::get('driver-pay14', 'api\MpesaController@STKPush4500');
    Route::get('driver-pay15', 'api\MpesaController@STKPush5000');
});
