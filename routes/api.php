<?php

use Illuminate\Http\Request;

Route::group(['prefix' => '/auth', ['middleware' => 'throttle:20,5']], function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
});


Route::group(['prefix' => 'v1', ['middleware' => 'jwt.auth']], function () {

    Route::get('/me', 'MeController@index');
    Route::get('/auth/logout', 'MeController@logout');

    Route::apiResource('users', 'UserController');
    Route::apiResource('drivers', 'DriverController');
    Route::apiResource('owners', 'OwnerController');
    Route::apiResource('vehicles', 'VehicleController');
    Route::apiResource('services', 'ServiceController');
    Route::apiResource('documents', 'DocumentController');
    Route::apiResource('expenses', 'ExpenseController');
    Route::apiResource('expenditures', 'ExpenditureController');


    Route::get('all-payments', 'MpesaController@driver_payments');
    Route::get('show-payment/{id}', 'MpesaController@show_payment');
    Route::get('account-balance', 'MpesaController@accountBalance');
    Route::get('make-payment', 'MpesaController@makePayment');
    Route::get('driver-pay2', 'MpesaController@STKPush1000');
    Route::get('driver-pay3', 'MpesaController@STKPush1200');
    Route::get('driver-pay4', 'MpesaController@STKPush1300');
    Route::get('driver-pay5', 'MpesaController@STKPush1500');
    Route::get('driver-pay6', 'MpesaController@STKPush1600');
    Route::get('driver-pay7', 'MpesaController@STKPush1700');
    Route::get('driver-pay8', 'MpesaController@STKPush1800');
    Route::get('driver-pay9', 'MpesaController@STKPush2000');
    Route::get('driver-pay10', 'MpesaController@STKPush2500');
    Route::get('driver-pay11', 'MpesaController@STKPush3000');
    Route::get('driver-pay12', 'MpesaController@STKPush3500');
    Route::get('driver-pay13', 'MpesaController@STKPush4000');
    Route::get('driver-pay14', 'MpesaController@STKPush4500');
    Route::get('driver-pay15', 'MpesaController@STKPush5000');
});
