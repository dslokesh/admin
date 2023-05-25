<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AjexController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HotelCategoryController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\AirlinesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\TransfersController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\VouchersController;
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

/* Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/thank-you', [AuthController::class, 'thankyou'])->name('thankyou');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('resetpassword', [AuthController::class, 'showResetForm'])->name('resetpassword');
Route::post('password/email', [AuthController::class, 'resetPassword'])->name('password.email');
Route::get('forgot-password/{token}', [AuthController::class, 'forgotPasswordValidate']);
Route::put('reset-password', [AuthController::class, 'updatePassword'])->name('reset-password');

Route::get('phpinfo', function () {
    phpinfo();
})->name('phpinfo');
//Route::get('/', 'HomeController@index')->name('home.index');


Route::get('users/getUsers', [UsersController::class, "getUsers"])->name('users.getUsers');
Route::post('state-list', [AjexController::class, "getStateByCountrySelect"])->name('state.list');
Route::post('city-list', [AjexController::class, "getCityByStateSelect"])->name('city.list');
Route::group(['middleware' => 'disable_back_btn'], function () {
    Route::group(['middleware' => ['auth']], function () {
        /**
         * Logout Routes
         */
        //Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('change-password', [AuthController::class, 'changepassword'])->name('change-password');
        Route::post('profile/save/{id?}', [AuthController::class, 'saveProfile'])->name('profile.save');

        Route::resource('modules', ModulesController::class);
        Route::resource('roles', RolesController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('states', StateController::class);
        Route::resource('cities', CityController::class);
        Route::resource('hotelcategories', HotelCategoryController::class);
        Route::resource('hotels', HotelController::class);
        Route::resource('airlines', AirlinesController::class);
        Route::resource('customers', CustomersController::class);
        Route::resource('suppliers', SuppliersController::class);
        Route::get('suppliers-markup-activity/{id?}', [SuppliersController::class, 'priceMarkupActivityList'])->name('suppliers.markup.activity');
        Route::post('suppliers-markup-activity-save', [SuppliersController::class, 'priceMarkupActivitySave'])->name('suppliers.markup.activity.save');
        Route::get('suppliers-markup-price/{id?}', [SuppliersController::class, 'markupPriceList'])->name('suppliers.markup.price');
        Route::post('suppliers-markup-price-save', [SuppliersController::class, 'markupPriceSave'])->name('suppliers.markup.price.save');
        Route::resource('agents', AgentsController::class);
        Route::get('agents-markup-activity/{id?}', [AgentsController::class, 'priceMarkupActivityList'])->name('agents.markup.activity');
        Route::post('agents-markup-activity-save', [AgentsController::class, 'priceMarkupActivitySave'])->name('agents.markup.activity.save');
        Route::get('agents-markup-price/{id?}', [AgentsController::class, 'markupPriceList'])->name('agents.markup.price');
        Route::post('agents-markup-price-save', [AgentsController::class, 'markupPriceSave'])->name('agents.markup.price.save');
        Route::resource('zones', ZonesController::class);
        Route::resource('vehicles', VehiclesController::class);
        Route::resource('activities', ActivitiesController::class);
        Route::get('activity-prices-create/{id?}', [ActivitiesController::class, 'createPriceForm'])->name('activity.prices.create');
        Route::get('activity-prices-edit/{id?}', [ActivitiesController::class, 'editPriceForm'])->name('activity.prices.edit');
        Route::post('activity-prices-save', [ActivitiesController::class, 'activityPriceSave'])->name('activity.prices.save');
        Route::get('activity-prices-add-new-row', [ActivitiesController::class, 'newRowAddmore'])->name('activity.prices.new.row');
        Route::resource('transfers', TransfersController::class);
        Route::resource('vouchers', VouchersController::class);
        Route::get('auto-agent', [VouchersController::class, 'autocompleteAgent'])->name('auto.agent');
        Route::get('auto-customer', [VouchersController::class, 'autocompleteCustomer'])->name('auto.customer');
        Route::get('add-hotels-vouchers/{vid?}', [VouchersController::class, 'addHotelsList'])->name('voucher.add.hotels');
        Route::get('hotel-view-vouchers/{hid?}/{vid?}', [VouchersController::class, 'addHotelsView'])->name('voucher.hotel.view');
        Route::get('voucher-hotel-new-row', [VouchersController::class, 'newRowAddmore'])->name('voucher.hotel.new.row');
        Route::post('voucher-hotel-save', [VouchersController::class, 'hotelSaveInVoucher'])->name('voucher.hotel.save');
        Route::delete('voucher-hotel-delete/{id}', [VouchersController::class, 'destroyHotelFromVoucher'])->name('voucher.hotel.delete');
        //Route::post('register', [UsersController::class, 'register'])->name('register');
		
		Route::get('add-activity-vouchers/{vid?}', [VouchersController::class, 'addActivityList'])->name('voucher.add.activity');
        Route::get('activity-view-vouchers/{aid?}/{vid?}', [VouchersController::class, 'addActivityView'])->name('voucher.activity.view');
        Route::post('get-pvt-transfer-amount', [VouchersController::class, 'getPVTtransferAmount'])->name('voucher.getPVTtransferAmount');
		Route::post('voucher-activity-save', [VouchersController::class, 'activitySaveInVoucher'])->name('voucher.activity.save');
		 Route::delete('voucher-activity-delete/{id}', [VouchersController::class, 'destroyActivityFromVoucher'])->name('voucher.activity.delete');
        Route::resource('users', UsersController::class);

        Route::get('permissions', [PermissionRoleController::class, 'index'])->name('permrole.index');
        Route::post('permissions/save', [PermissionRoleController::class, 'postSave'])->name('permrole.save');
    });
});

// THIS ROUTE FOR TEXT EDITOR
Route::get('media/image/browse', [MediaController::class, 'browseImage'])->name('media.image.browse');
Route::post('media/uploadImage', [MediaController::class, 'uploadImage'])->name('media.upload');
Route::post('file/upload', [MediaController::class, 'uploadFile'])->name('file.upload');

// THIS ROUTE FOR DELETE IMAGE FROM FILEINPUT FILES TABLE
Route::get('fileinput/image-delete/{id}', [MediaController::class, 'imageDelete'])->name('fileinput.imagedelete');

/* Function for print array in formated form */
if (!function_exists('pr')) {
    function pr($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}

/* Function for print query log */
if (!function_exists('qLog')) {
    DB::enableQueryLog();
    function qLog()
    {
        pr(DB::getQueryLog());
    }
}




//Route::group(['namespace' => 'App\Http\Controllers'], function()
//{   
/**
 * Home Routes
 */
//Route::get('/', 'HomeController@index')->name('home.index');
/*Route::get('/register', 'RegisterController@show')->name('register.show');
    Route::post('/register', 'RegisterController@register')->name('register.perform');
    Route::get('/login', 'LoginController@show')->name('login.show');
    Route::post('/login', 'LoginController@login')->name('login.perform'); */
//Route::group(['middleware' => ['guest']], function() {
/**
 * Register Routes
 */
// Route::get('/register', 'RegisterController@show')->name('register.show');
// Route::post('/register', 'RegisterController@register')->name('register.perform');

/**
 * Login Routes
 */
//Route::get('/login', 'LoginController@show')->name('login.show');
// Route::post('/login', 'LoginController@login')->name('login.perform');

//});

//Route::group(['middleware' => ['auth']], function() {
/**
 * Logout Routes
 */
        //Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    //});
//});