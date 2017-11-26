<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Dingo\Api\Routing\Helpers;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function postRegister(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:user',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            throw new StoreResourceFailedException("Validation Error", $validator->errors());
        }

        $user = User::create(User::create_array($request));

        if($user){

            $token = JWTAuth::fromUser($user);

            //通过用户获取token
            //$user = JWTAuth::toUser( $tokenStr );

            return $this->response->array([
                "token" => $token,
                "message" => "User created",
                "status_code" => 201
            ]);
        }
        else
        {
            return $this->response->error("User Not Found...", 404);
        }
    }

}