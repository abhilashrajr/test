<?php

use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'App\Http\Controllers\HomeController@index');

Auth::routes();




Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/checkout', 'App\Http\Controllers\HomeController@checkout')->name('checkout');
Route::get('/payment', 'App\Http\Controllers\HomeController@payment')->name('payment');
Route::post('/getaddons','App\Http\Controllers\HomeController@getaddons');
Route::post('/addtocart','App\Http\Controllers\HomeController@addtocart');
Route::post('/removeitem','App\Http\Controllers\HomeController@removeitem');
Route::get('/emptycart','App\Http\Controllers\HomeController@emptycart');
Route::get('/getcartdetails','App\Http\Controllers\HomeController@getcartdetails');
Route::get('/deliveryfee','App\Http\Controllers\HomeController@deliveryfee');
Route::post('/order','App\Http\Controllers\HomeController@order')->name('order');
Route::get('/confirmation','App\Http\Controllers\HomeController@confirmation')->name('confirmation');
Route::get('/confirmed','App\Http\Controllers\HomeController@confirmed')->name('confirmed');
Route::get('/rejected','App\Http\Controllers\HomeController@rejected')->name('rejected');
Route::get('/payment-failure','App\Http\Controllers\HomeController@paymentfailure')->name('payment-failure');
Route::get('/calcdistance', 'App\Http\Controllers\HomeController@calcdistance');
Route::get('/booking','App\Http\Controllers\HomeController@booking')->name('booking');
Route::get('/sbooking','App\Http\Controllers\HomeController@sbooking')->name('sbooking');
Route::post('/bookingconfirmation','App\Http\Controllers\HomeController@bookingconfirmation')->name('bookingconfirmation');
Route::get('/gettimeslot', 'App\Http\Controllers\BookingController@timeslot');
Route::get('/confirmstatus','App\Http\Controllers\HomeController@confirmstatus');
Route::get('/dinein','App\Http\Controllers\DineinController@index')->name('dinein');
Route::get('/dineincheckout', 'App\Http\Controllers\DineinController@checkout')->name('dineincheckout');
Route::post('/dineinorder','App\Http\Controllers\DineinController@order')->name('dineinorder');
Route::get('/dineinpayment', 'App\Http\Controllers\HomeController@dineinpayment')->name('dineinpayment');
Route::get('/dineinconfirmation','App\Http\Controllers\HomeController@dineinconfirmation')->name('dineinconfirmation');
Route::get('/dineinconfirmed','App\Http\Controllers\DineinController@confirmed')->name('dineinconfirmed');
Route::get('/dineinrejected','App\Http\Controllers\DineinController@rejected')->name('dineinrejected');
Route::get('/dineinpayment-failure','App\Http\Controllers\DineinController@paymentfailure');
Route::get('/paynow','App\Http\Controllers\PaynowController@index')->name('paynow');
Route::post('/paynowsave','App\Http\Controllers\PaynowController@save')->name('paynowsave');
Route::get('/paynowpayment', 'App\Http\Controllers\HomeController@paynowpayment')->name('paynowpayment');
Route::get('/paynowconfirmation','App\Http\Controllers\HomeController@paynowconfirmation')->name('paynowconfirmation');
Route::get('/paynowpayment-failure','App\Http\Controllers\PaynowController@paymentfailure');
Route::get('/privacy-policy', 'App\Http\Controllers\HomeController@privacy')->name('privacy-policy');
Route::get('/vouchers', 'App\Http\Controllers\HomeController@voucher')->name('vouchers');
Route::get('/vouchercheckout/{id}', 'App\Http\Controllers\HomeController@vouchercheckout')->name('vouchercheckout');
Route::post('/voucherorder/{id}', 'App\Http\Controllers\VoucherController@order')->name('voucherorder');
Route::get('/voucherpayment', 'App\Http\Controllers\HomeController@voucherpayment')->name('voucherpayment');
Route::get('/voucherconfirmation','App\Http\Controllers\HomeController@voucherconfirmation')->name('voucherconfirmation');
Route::get('/voucherpayment-failure','App\Http\Controllers\VoucherController@paymentfailure');
Route::post('/savefeedback','App\Http\Controllers\FeedbackController@store')->name('savefeedback');
Route::get('/orderplaced','App\Http\Controllers\HomeController@orderplaced')->name('orderplaced');
Route::post('/applycoupon','App\Http\Controllers\CouponController@apply')->name('applycoupon');

Route::get('/test', 'App\Http\Controllers\HomeController@test');















Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', [App\Http\Controllers\PageController::class, 'dashboard'])->name('dashboard');
	Route::get('/stats','App\Http\Controllers\PageController@stats');
	Route::POST('/stats','App\Http\Controllers\PageController@stats')->name('stats');
	Route::get('/exportstats','App\Http\Controllers\PageController@exportstats')->name('exportstats');
	
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('category','App\Http\Controllers\CategoryController');
	Route::resource('addoncategory','App\Http\Controllers\AddonCategoryController');
	Route::resource('addonitem','App\Http\Controllers\AddonitemController');
	Route::resource('menu','App\Http\Controllers\MenuController');
	Route::resource('size','App\Http\Controllers\SizeController');
	Route::resource('settings','App\Http\Controllers\SettingsController');
	Route::resource('coupon','App\Http\Controllers\CouponController');
	Route::resource('voucher','App\Http\Controllers\VoucherController');

	Route::post('get_categories', ['App\Http\Controllers\MenuController', 'get_categories']);
	Route::get('/orders', 'App\Http\Controllers\OrderController@orders')->name('orders');
	Route::get('/dineinorders', 'App\Http\Controllers\OrderController@dineinorders')->name('dineinorders');
	Route::get('/paynoworders', 'App\Http\Controllers\OrderController@paynoworders')->name('paynoworders');
	Route::get('/voucherorders', 'App\Http\Controllers\VoucherController@orders')->name('voucherorders');
	Route::get('/orderview/{id}', 'App\Http\Controllers\OrderController@orderview')->name('orderview');
	Route::get('/paynowview/{id}', 'App\Http\Controllers\OrderController@paynowview')->name('paynowview');
	Route::get('/voucherorderview/{id}', 'App\Http\Controllers\VoucherController@orderview')->name('voucherorderview');
	Route::get('/vostatus/{id}/{status}', 'App\Http\Controllers\VoucherController@changestatus')->name('vostatus');
	Route::get('/exportorders', 'App\Http\Controllers\OrderController@export')->name('exportorders');
	Route::get('/changestatus/{id}/{status}', 'App\Http\Controllers\OrderController@changestatus')->name('changestatus');
	Route::get('/change', 'App\Http\Controllers\CommonController@change');
	Route::get('/bookings', 'App\Http\Controllers\BookingController@index')->name('bookings');
	Route::get('/bookingview/{id}', 'App\Http\Controllers\BookingController@show')->name('bookingview');
	Route::get('/bookingstatus/{id}/{status}', 'App\Http\Controllers\BookingController@status')->name('bookingstatus');
	Route::get('/feedbacks', 'App\Http\Controllers\FeedbackController@index')->name('feedbacks');
	/*
	Route::get('category', [ CategoryController::class, 'index' ]);
	Route::get('category/create', [ CategoryController::class, 'create' ])->name('category.create');
	Route::post('category/store', [ CategoryController::class, 'store' ]);
	//Route::put('category/store', ['as' => 'category.store', 'category' => 'App\Http\Controllers\CategoryController@store']);
	//Route::resource('category', 'App\Http\Controllers\CategoryController');*/


	//Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);

});



//remove later


Route::get('/route-cache', function() {
     $exitCode = Artisan::call('route:cache');
     return 'Routes cache cleared';
 });
Route::get('/config-cache', function() {
     $exitCode = Artisan::call('config:cache');
     return 'Config cache cleared';
 });

 Route::get('/clear-cache', function() {
     $exitCode = Artisan::call('cache:clear');
     return 'Application cache cleared';
 });
 Route::get('/view-clear', function() {
     $exitCode = Artisan::call('view:clear');
	$exitCode = Artisan::call('view:cache');
     return 'View cache cleared.';
 });
  Route::get('/migrate1', function() {
     $exitCode = Artisan::call('migrate');
     return 'migrated';
 });