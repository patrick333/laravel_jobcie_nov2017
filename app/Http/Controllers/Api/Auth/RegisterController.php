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

use App\Tools\Functions;
use App\Tools\ApiErrorResp;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function postRegister(Request $request)
    {  
        $rData = new \stdClass;
        if ($request->isMethod('post')) {

            $errors = Functions::_validateInput($request->all(), [
                'username' => 'required|unique:user',
                'email' => 'required|email|max:255|unique:user',
                'password' => 'required|min:1',
            ]);

            $errors = $this->_CheckValue($request);

            if($errors)
            {
                return Functions::_errorResponse($errors);
            }

            $user = User::create(User::create_array($request));

            if($user)
            {
                $token = JWTAuth::fromUser($user);
            }

            if($token)
            {
                $request->session()->put('token', $token);
                $rData->message = 'success';
                $rData->token = $token;

                return Functions::_dataResponse($rData);
            }
            return Functions::_errorResponse('fail');
        }
        return response()->json(ApiErrorResp::responseBadRequest(), 400);
    }

    /*
    |--------------------------------------------------------------------------
    | Check USERNAME AND EMAIL 
    |--------------------------------------------------------------------------
    */
    public function _CheckValue(Request $request)
    {
        $errors = array();
        $count_username = User::where('username', trim_null_rl($request->input('username')))->count();
        if($count_username)
        {
            $errors[] = ' username_has_been_used';
        }
        $count_email = User::where('email', trim_null_rl($request->input('email')))->count();
        if($count_email)
        {
            $errors[] = 'email_has_been_used';
        }

        return $errors;
    }

}