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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::post('login' , 'Api\AuthController@login');
Route::group(['namespace' => 'Api',  'middleware' => 'APIToken'], function() {




    Route::get('get_doctor_subjects' , 'SubjectController@getsubjects');

    Route::post('get_lecture' , 'LectureController@getLecture');


    Route::post('create_lecture' , 'LectureController@createLecture');


    Route::post('create_attendance' , 'AttendanceController@addAttendance');

    Route::post('get_attendance' , 'AttendanceController@getAttendance');


    Route::get('logout' , 'AuthController@logout');

    Route::post('reset_password' , 'AuthController@resetPassword');




});
