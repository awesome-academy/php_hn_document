<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'localization'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::post('/follow/{id}', 'UserController@follow')->name('follow');
    Route::post('/unfollow/{id}', 'UserController@unfollow')->name('unfollow');
    Route::resource('documents', 'DocumentController', [
        'as' => 'user',
    ]);
    Route::get('upload', 'DocumentController@upload')->name('user.documents.upload');
    Route::post('upload', 'DocumentController@storeUpload')->name('user.documents.storeUpload');
});

Route::get('change-language/{locale}', 'LocalizationController@changeLanguage')->name('change-language');
