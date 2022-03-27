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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Broadcast::routes(['middleware' => ['auth:web']]);
Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('login', 'AuthController@login');
  Route::post('register', 'AuthController@register');

  Route::group([
    'middleware' => 'auth:api'
  ], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
  });
});
Route::group(['prefix'=>'paypal'], function(){
    Route::post('/order/create', 'PaypalController@create')->name('paypal_create');
    Route::post('/order/{orderid}/capture', 'PaypalController@capture')->name('paypal_capture');

});


Route::any("Customers/Auth",'CustomersController@auth');
Route::any("Customers/Accounting",'CustomersController@Accounting');
Route::any("Customers/check_quota",'CustomersController@check_quota');
Route::any("Customers/disconnect",'CustomersController@disconnect');
Route::any("Customers/test_api",'CustomersController@test_api');
Route::any("Hotspot/redirect/referral/{url}",'HotspotController@redirect_referral');

