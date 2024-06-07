<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegulerController;
use App\Http\Controllers\ExpressController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\WalletDriverController;
use App\Http\Controllers\UserController;

Route::get('/','App\Http\Controllers\HomeController@index')->middleware('auth');
Route::get('/clear/route', 'App\Http\Controllers\HomeController@clearRoute')->name('clear')->middleware('auth');
// Route::get('/', function () use ($router){
//     // return "Daeng Kurir API V1";
//     try {
//         DB::connection()->getPdo();
//         echo "Connected successfully to: " . DB::connection()->getDatabaseName();
//     } catch (\Exception $e) {
//         die("Could not connect to the database. Please check your configuration. error:" . $e );
//     }
// });
// try {
//     DB::connection()->getPdo();
//     echo "Connected successfully to: " . DB::connection()->getDatabaseName();
// } catch (\Exception $e) {
//     die("Could not connect to the database. Please check your configuration. error:" . $e );
// }
// Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
// Route::post('login', [AuthController::class, 'login']);
// Route::get('register', [AuthController::class, 'showFormRegister'])->name('register');
// Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', 'App\Http\Controllers\AuthController@showFormLogin')->name('login');
Route::post('login', 'App\Http\Controllers\AuthController@login');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::post('/create/user', [UserController::class, 'createUser'])->name('create.users');
	Route::get('/all/user', [UserController::class, 'userList'])->name('all-inOne');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::post('profile/change-status', ['as' => 'profile.changeStatus', 'uses' => 'App\Http\Controllers\ProfileController@changeStatus']);

	Route::get('/order-detail/{id}', [HomeController::class, 'detail'])->name('order.detail');

	Route::get('/reguler', [RegulerController::class, 'index'])->name('reguler.index');
	Route::post('/reguler/order', [RegulerController::class, 'createOrder'])->name('create.reguler');
	Route::get('/reguler/all', [RegulerController::class, 'allReguler'])->name('all.reguler');
	Route::get('/reguler/all-reguler', [RegulerController::class, 'allRegulerDisplay'])->name('all-reguler');
	Route::get('/reguler/change-driver/filter',[RegulerController::class, 'changeDriverFilterList'])->name('all-reguler-driver');
	Route::post('/reguler/driver/change-driver-pickup',[RegulerController::class, 'changeDriverPickUp'])->name('change-reguler-pickup');
    Route::post('/reguler/driver/change-driver-deliver',[RegulerController::class, 'changeDriverDelivery'])->name('change-reguler-deliver');
	Route::post('/reguler/status',[RegulerController::class, 'status'])->name('reguler-status');
	Route::post('/reguler/print-barcode',[RegulerController::class, 'printBarcode'])->name('reguler-printBarcode');
	Route::get('user/customer',[RegulerController::class, 'userListCustomer'])->name('customer.list');
	Route::get('user/area',[RegulerController::class, 'area'])->name('customer.area');
	Route::get('order/barcode',[RegulerController::class, 'checkout_barcode'])->name('order.barcode');
	Route::get('order/excel',[RegulerController::class, 'printExcelReguler'])->name('order.excel');
	Route::get('order/excelExpress',[RegulerController::class, 'printExcelExpress'])->name('order.excelExpress');
	
	Route::get('/express', [ExpressController::class, 'index'])->name('express.index');
	Route::post('/express/order', [ExpressController::class, 'createOrder'])->name('create.express');
	Route::get('/express/all-express', [ExpressController::class, 'allExpressDisplay'])->name('all-express');
    Route::get('/express/change-driver/filter',[ExpressController::class, 'changeDriverFilterList'])->name('all-express-driver');
	
	//driver
	Route::get('/driver/{slug}', [DriverController::class, 'index'])->name('driver.index');
	Route::get('driver-reg/{id}',[DriverController::class, 'allDriverDisplay'])->name('driver.reguler');
    Route::get('driver-exp/{id}',[DriverController::class, 'allDriverDisplay'])->name('driver.express');
	Route::post('driver/set-balance',[DriverController::class, 'setSaldo'])->name('driver.setBalance');
    Route::post('driver-exp/set-balance',[DriverController::class, 'setSaldoExp'])->name('driver.setBalanceExp');
    Route::post('driver/setPlacement',[DriverController::class, 'setPlacement'])->name('driver.setPlacement');


	//wallet
	Route::get('/driver-wallet', [WalletDriverController::class, 'index'])->name('driver.wallet');
	Route::get('/wallet/all-reguler', [WalletDriverController::class, 'allWalletDisplay'])->name('all-wallet-reguler');
	Route::get('wallet/{id}',[WalletDriverController::class, 'driverWalletDetail'])->name('wallet-detail');
	Route::post('driver/add-balance',[WalletDriverController::class, 'addSaldo'])->name('add_saldo');
	Route::post('driver/pull-balance/',[WalletDriverController::class, 'pullBalance'])->name('pull_balance');

	Route::get('region',[RegulerController::class, 'region'])->name('customer.region');
    Route::get('special-delivery-fee/{id}',[RegulerController::class, 'specialDeliveryFee'])->name('delivery.fee');
    Route::get('special-pickup-fee/{id}',[RegulerController::class, 'specialPickupFee'])->name('pickup.fee');

});

