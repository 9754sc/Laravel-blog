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

Route::group(['middleware' => 'language'], function() {
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::group(['middleware' => 'auth'], function () {

        Route::get('logout', function () {
            Auth::logout();
            return redirect()->to('/');
        });

        Route::get('home', 'PostController@index');

        //    Route::resource('post', 'PostController', ['except' => 'show']);
        Route::resource('post', 'PostController');
        Route::get('post/{post}/delete', ['as' => 'post.delete', 'uses' => 'PostController@delete']);
        Route::get('post/{slug}', ['as' => 'post.show', 'uses' => 'PostController@show']);


        Route::resource('user', 'UserController');
        Route::get('user/{id}/{slug}', ['as' => 'user.show', 'uses' => 'UserController@show']);


        Route::resource('tag', 'TagController');
        Route::get('tag/{slug}', ['as' => 'user.show', 'uses' => 'UserController@show']);

    });

    // oAuth
    Route::get('auth/{service}', 'Auth\AuthController@redirectToProvider')
        ->where('service', '(github|facebook)');
    Route::get('auth/{service}/callback', 'Auth\AuthController@handleProviderCallback')
        ->where('service', '(github|facebook)');

    Route::get('lang/{lang}', 'Auth\AuthController@setLanguage');

});