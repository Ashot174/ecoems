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


Route::get('/', 'IndexController@index')->name('index');

//Route::group(['middleware' => ['web']], function () {
//    Route::get('/about', 'Front\AboutController@index');
//});

Route::get('/test', function (){
    return view('test');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::post('/user/register','User\RegisterController@create')->name('register');
});

Auth::routes(['register' => false]);

Route::get('password/change', 'ChangePasswordController@index')->name('changePasswordForm');
Route::post('password/change', 'ChangePasswordController@store')->name('password.change');

Route::match(['GET', 'POST'], '/profile', 'ProfileController@index')->name('profile.index');
Route::match(['GET', 'POST'],'/profile/projects', 'ProfileController@projects')->name('projects.show');

Route::get('/profile/project/analytics/{id}', 'ProjectController@analytics')->name('project.analytics');
Route::match(['GET', 'POST'], '/profile/project/database/{id}', 'ProjectController@database')->name('project.database');
Route::post('/profile/project/export{id}', 'ProjectController@export')->name('project.report');
Route::get('/profile/project/map/{id}', 'ProjectController@map')->name('project.map');

