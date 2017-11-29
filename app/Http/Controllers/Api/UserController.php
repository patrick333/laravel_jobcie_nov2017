<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;
use App\User;
use App\Http\Transformers\UserTransformer;

class UserController extends BaseController
{

    public function __construct()
    {
    	//是否验证admin
        //$this->middleware('jwt.basic:admin');
    }
    
    public function getIndex()
    {

        // $users = User::paginate(25);
		// return $this->response->paginator($users, new UserTransformer);

    	// $user = User::findOrFail(1);
    	// return $this->response->item($user, new UserTransformer);
        // return $this->_dataResponse($user->toArray());

        //return User::all();
    	//return JWTAuth::toUser(JWTAuth::getToken());
        //return $this->auth->user();
        //return app('Dingo\Api\Auth\Auth')->user();
        return Auth::guard('api')->user();
    }
}
