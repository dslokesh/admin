<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserAreasController;
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
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('resetpassword', [AuthController::class, 'showResetForm'])->name('resetpassword');
Route::post('password/email', [AuthController::class, 'resetPassword'])->name('password.email');
Route::get('forgot-password/{token}', [AuthController::class, 'forgotPasswordValidate']);
Route::put('reset-password', [AuthController::class, 'updatePassword'])->name('reset-password');

    //Route::get('/', 'HomeController@index')->name('home.index');
    
    Route::get('companies/getCompanies/', [CompanyController::class, "getCompanies"])->name('companies.getCompanies');
    Route::get('users/getUsers/', [UsersController::class, "getUsers"])->name('users.getUsers');
    Route::group(['middleware' => 'disable_back_btn'], function () {
        Route::group(['middleware' => ['auth']], function() {
            /**
             * Logout Routes
             */
            //Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); 
            Route::get('change-password', [AuthController::class, 'changepassword'])->name('change-password');
            Route::post('profile/save/{id?}', [AuthController::class, 'saveProfile'])->name('profile.save');

            Route::resource('categories', CategoryController::class);
            Route::resource('companies', CompanyController::class);
            //Route::get('/companies/getCompanies/','CompanyController@getCompanies')->name('companies.getCompanies');
            //Route::get('companies/getCompanies/', [CompanyController::class, "getCompanies"])->name('companies.getCompanies');

            Route::resource('modules', ModulesController::class);
            Route::resource('areas', AreasController::class);
            Route::resource('roles', RolesController::class);
            Route::resource('products', ProductsController::class);

            //Route::post('register', [UsersController::class, 'register'])->name('register');
            Route::resource('users', UsersController::class);
            //Route::get('users/getUserAreas/{userid}', [UsersController::class, "getUserAreas"])->name('users.areas');
            Route::resource('userareas', UserAreasController::class);

        });
    });


/* Function for print array in formated form */
if(!function_exists('pr')){
	function pr($array){
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
}
	
/* Function for print query log */
if(!function_exists('qLog')){
	DB::enableQueryLog();
	function qLog(){
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


