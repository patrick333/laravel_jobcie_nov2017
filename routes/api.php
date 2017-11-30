<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');

$api->version(['v1'], function ($api) {
	$api->group(['middleware' => ['web','jwt:session'] ,'namespace' => 'App\Http\Controllers\Api'], function ($api){

		$api->post('login',     'Auth\LoginController@postLogin');
		$api->post('refresh',   'Auth\LoginController@postRefershToken');
		$api->get('logout',    'Auth\LoginController@postLogout');
		$api->post('logout',    'Auth\LoginController@postLogout');
		$api->post('register',  'Auth\RegisterController@postRegister');

		$api->get('user', ['middleware' => 'jwt.auth', 'uses' => 'UserController@getIndex' ]);

		$api->get('test', function (Request $request) {
		    dd(app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.login'));
		});


	}); 
}); 