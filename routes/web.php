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
    return view('index');
});


Route::get('login',  ['middleware' => 'validate:login','as' => 'login', 'uses' => 'LoginController@getLogin']);
Route::get('signup', ['middleware' => 'validate:login','as' => 'signup', 'uses' => 'LoginController@getSignup']);
Route::get('password/reset', ['middleware' => 'validate:login','uses' => 'LoginController@getPasswordReset']);
Route::get('logout', 'LoginController@getLogout');


Route::group(['prefix' => 'home', 'middleware' => 'validate:user'], function() {
    Route::get('/','UserController@getIndex');

});


/*
|--------------------------------------------------------------------------
| TEST
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'test'], function() {
    Route::get('email/password_resets', function () {
	    return new App\Mail\PasswordResets();
	});
});


