<?php

use Illuminate\Http\Request;

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

// Route::namespace("Cost")->middleware([])->get('/consultations/{id}', 'Cost\ServiceFreeController@consultation');
   
Route::prefix('cost')->middleware([])->namespace('Cost')->group(function ($router) {
    $router->get('/consultations', 'ServiceFreeController@consultations');
    $router->post('/consultations', 'ServiceFreeController@addConsultation');
    $router->delete('/consultations/{id}', 'ServiceFreeController@deleteConsultation');
    $router->put('/consultations/{id}', 'ServiceFreeController@updateConsultation');

    $router->get('/members', 'AccoutController@index');
    $router->get('/memberinfo', 'AccoutController@is_role');
    $router->post('/members', 'AccoutController@add');
    $router->delete('/members/{id}', 'AccoutController@delete');
    $router->put('/members/{id}', 'AccoutController@update');
    $router->put('/bank/{id}', 'AccoutController@bank');

    $router->get('/banklist/{id}', 'ServiceFreeController@banklist');
    $router->get('/deletebank/{id}', 'ServiceFreeController@deletebank');

    $router->get('/tags','ServiceFreeController@taglist');
    $router->post('/tags','ServiceFreeController@addtag');
    $router->put('/tags/{id}','ServiceFreeController@updatetag');
    $router->delete('/tags/{id}','ServiceFreeController@deletetag');

    $router->get('/hospitals','HospitalController@show');
    $router->post('/hospitals','HospitalController@add');
    $router->put('/hospitals/{id}','HospitalController@update');
    $router->delete('/hospitals/{id}','HospitalController@delete');

    $router->get('/charge/{id}','PaymentController@charges');
    $router->post('/charge/{id}','PaymentController@add');
    $router->put('/charge/{id}','PaymentController@update');
    $router->put('/charges/{id}','PaymentController@cost');
    $router->delete('/charge/{id}','PaymentController@delete');

    $router->get('/msearch/{name}','PaymentController@msearch');
    $router->get('/msearchs/{name}','PaymentController@causesearchs');
    $router->get('/usearchs/{name}','PaymentController@usersearchscause');
    $router->get('/csearch','PaymentController@csearch');
    $router->get('/csearchs/{id}','PaymentController@csearchs');
    $router->get('/hsearch/{name}','PaymentController@hsearch');

    // $router->put('/status/{id}','PayeeController@chargeStatus');
    $router->put('/status/{id}','PayeeController@chargeStatus');
    $router->put('/allstatus/{id}','PayeeController@allstatus');
    $router->put('/chargeinfo/{id}','PayeeController@changeCharge');
    $router->get('/alupdate/{id}','PayeeController@alreadyUpdate');
});

Route::prefix('common')->namespace('Common')->group(function ($router) {
    $router->get('qiniu/token', 'QiniuController@token');
    $router->post('login', 'UserController@login');
    $router->post('logout', 'UserController@logout');
});

Route::prefix('usercenter')->middleware(['auth:api'])->namespace('UserCenter')->group(function ($router) {
    $router->get('get_info', 'UserController@userInfo');
    $router->post('update_my_info', 'UserController@updateMyInfo');
    $router->post('change_phone', 'UserController@changePhone');
});