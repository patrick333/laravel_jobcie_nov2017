<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use App\Http\Transformers\UserTransformer;

class UserController extends BaseController
{

    public function __construct()
    {
    	//是否验证admin
        $this->middleware('jwt.admin');
    }
    
    public function index()
    {

  //   	$users = User::paginate(25);
		// return $this->response->paginator($users, new UserTransformer);

    	// $user = User::findOrFail(1);
    	// return $this->response->item($user, new UserTransformer);
        // return $this->_dataResponse($user->toArray());

    	//return JWTAuth::toUser(JWTAuth::getToken());
 		//return User::all();
 		$user = app('Dingo\Api\Auth\Auth')->user();
        $user = $this->auth->user();

        return $user;
    }
}
