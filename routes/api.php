<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['middleware' => 'auth'], function () { // c auth to api

	Route::post('merchant/merlogin','App\Http\Controllers\MerchantController@merlogin');//move
	Route::get('merchant/pendings','App\Http\Controllers\MerchantController@pendings');
	Route::get('merchant/merpending','App\Http\Controllers\MerchantController@merpending');
	Route::get('merchant/merallorders','App\Http\Controllers\MerchantController@merallorders');
	Route::get('merchant/merorderdetails','App\Http\Controllers\MerchantController@merorderdetails');
	Route::post('merchant/meraccept','App\Http\Controllers\MerchantController@meraccept');
	Route::get('merchant/meraccepts','App\Http\Controllers\MerchantController@meraccepts');
	Route::get('merchant/merbookaccept','App\Http\Controllers\MerchantController@merbookaccept');
	Route::get('merchant/merbookrejects','App\Http\Controllers\MerchantController@merbookrejects');
	Route::get('merchant/merpendingbooking','App\Http\Controllers\MerchantController@merpendingbooking');
	Route::get('merchant/merallbooking','App\Http\Controllers\MerchantController@merallbooking');
	Route::get('merchant/merbookdetails','App\Http\Controllers\MerchantController@merbookdetails');
	Route::get('merchant/merreport','App\Http\Controllers\MerchantController@merreport');
	Route::post('merchant/merreject','App\Http\Controllers\MerchantController@merreject');
	Route::get('merchant/merdeid','App\Http\Controllers\MerchantController@merdeid');
	Route::get('merchant/dpendings','App\Http\Controllers\MerchantController@dpendings');
	Route::get('merchant/ppendings','App\Http\Controllers\MerchantController@ppendings');
	Route::get('merchant/merdpending','App\Http\Controllers\MerchantController@merdpending');
	Route::get('merchant/merdallorders','App\Http\Controllers\MerchantController@merdallorders');
	Route::get('merchant/merpallorders','App\Http\Controllers\MerchantController@merpallorders');
	Route::get('merchant/merdorderdetails','App\Http\Controllers\MerchantController@merdorderdetails');
	Route::get('merchant/merporderdetails','App\Http\Controllers\MerchantController@merporderdetails');
	Route::post('merchant/merdaccept','App\Http\Controllers\MerchantController@merdaccept');
	Route::post('merchant/merpaccept','App\Http\Controllers\MerchantController@merpaccept');
	Route::get('merchant/merpendingvoucher','App\Http\Controllers\MerchantController@merpendingvoucher');
	Route::get('merchant/merallvoucher','App\Http\Controllers\MerchantController@merallvoucher');
	Route::get('merchant/mervoucherdetails','App\Http\Controllers\MerchantController@mervoucherdetails');
	Route::get('merchant/mervoucheraccept','App\Http\Controllers\MerchantController@mervoucheraccept');

	
//});