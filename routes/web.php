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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->post('/user/client/accept', 'User\ClientController@accept');
Route::middleware(['auth'])->any('/user/client/complain', 'User\ClientController@complain');
Route::middleware(['auth'])->resource('/user/client', 'User\ClientController');
Route::middleware(['auth'])->resource('/user/time-analysis', 'User\TimeAnalysisController');
Route::middleware(['auth'])->resource('/user/result-analysis', 'User\ResultAnalysisController');
Route::middleware(['auth'])->any('/user/setting', 'User\SettingController@index');
//Route::post('/user/setting', 'User\SettingController@index');

App::make('router')->get('
/tests', function () {
    return 222;
});
Route::group(['middleware' => ['web']], function () {

    Route::get('/code', 'CodeController@index');
    Route::post('/password/code', 'Auth\ForgotPasswordController@phone');
    Route::get('/test', 'HomeController@test')->name('test');
});

Route::middleware('web')->post('/code', 'CodeController@index');


