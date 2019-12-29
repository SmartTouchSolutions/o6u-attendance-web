<?php

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

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function() {
Route::get('/', 'AuthController@loginGet')->name('login');
Route::post('login_post', 'AuthController@loginPost')->name('loginPost');

// Student Login
Route::get('/studentLogin', 'AuthStudentController@loginGet')->name('loginStudentGet');
Route::post('/studentLogin_post', 'AuthStudentController@loginGet')->name('loginStudentPost');
});
// Logout
Route::get('logout', 'AuthController@logout')->name('logout');


Route::group(['middleware' => 'SuperAdmin'], function() {
Route::get('dashboard', 'Admin\DashboardController@dashboard')->name('index');

// Start Doctor
Route::resource('doctor', 'Admin\DoctorController');
// End Doctor

});

Route::group(['middleware' => 'auth'], function() {

Route::get('/soon' , 'Admin\DashboardController@soon');

});











//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
