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
});

// Student Login
Route::group(['middleware' => 'guest:student'], function() {
Route::get('studentLogin', 'AuthStudentController@loginGet')->name('loginStudentGet');
Route::post('/studentLogin_post', 'AuthStudentController@loginPost')->name('loginStudentPost');
});

Route::group(['middleware' => 'studentPages'], function() {

Route::get('student/attendance' , 'Student\AttendanceController@attendance');

});


// Route::group(['middleware' => 'SuperAdmin'], function() {
Route::get('dashboard', 'Admin\DashboardController@dashboard')->name('index');

// Start Doctor
Route::resource('doctor', 'Admin\DoctorController');
// End Doctor
// Start teacher
Route::resource('TeacherAssistant', 'Admin\TeacherAssistantController');
// End teacher

// Start Student
Route::resource('student', 'Admin\StudentController');
// End Student

// Start Student
Route::resource('subject', 'Admin\SubjectController');
// End Student
// });

// Start SuperAdmin Logout
Route::get('logout', 'AuthController@logout')->name('logout');
// End  SuperAdmin Logout

// Start Student Logout
Route::get('logoutStudent', 'AuthStudentController@logoutStudent')->name('logoutStudent');
// End  Student Logout

// Route::group(['middleware' => 'auth'], function() {

// Route::get('/soon' , 'Admin\DashboardController@soon');

// });














//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
