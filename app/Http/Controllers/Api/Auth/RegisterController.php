<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Tools\Functions;
use App\Tools\ApiErrorResp;

use App\User;
use App\UserPasswordResets;

class RegisterController extends Controller
{
    use RegistersUsers;
    use Helpers;

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
        abort(400, 'Bad request, wrong method.');
    }

    public function postReset(Request $request)
    {
        $rData = new \stdClass;
        if ($request->isMethod('post')) {

            $errors = Functions::_validateInput($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required|min:1',
            ]);

            $check_email = User::where('email', trim_null_rl($request->input('email')))->first();
            if(empty($check_email))
            {
                $errors[] = 'no_account_found';
            }
            if($errors)
            {
                return Functions::_errorResponse($errors);
            }

            $email_info = UserPasswordResets::where('email',trim_null_rl($request->input('email')))->first();

            $current_time = time();
            $token = csrf_token();

            if(empty($email_info))
            {
                $array = [
                    'uid' => $check_email->id,
                    'token' => $token,
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'code' => UserPasswordResets::_genCode(),
                    'expire_at' => $current_time + 600, //10 min;
                    'status' => 0,
                    'created_at' => $current_time,
                    'updated_at' => $current_time,
                ];

                $result = UserPasswordResets::insertGetId($array);
            }
            else
            {
                $array_update = [
                    'token' => $token,
                    'password' => bcrypt($request->input('password')),
                    'code' => UserPasswordResets::_genCode(),
                    'expire_at' => $current_time + 600, //10 min;
                    'status' => 0,
                    'updated_at' => $current_time,
                ];

                $result = UserPasswordResets::where('id',$email_info->id)->update($array_update);
            }

            if($result)
            {
                $rData->message = 'success';
                $rData->token = $token;

                return Functions::_dataResponse($rData);
            }

            return Functions::_errorResponse('fail');
        }
        abort(400, 'Bad request, wrong method.');
    }

    public function postVerify(Request $request)
    {
        $rData = new \stdClass;
        if ($request->isMethod('post')) {

            $errors = Functions::_validateInput($request->all(), [
                'token' => 'required',
                'code' => 'required|max:6'
            ]);

            $check_code = UserPasswordResets::where('token', trim_null_rl($request->input('token')))
                                            ->where('code', trim_null_rl($request->input('code')))
                                            ->first();

            if(empty($check_code))
            {
                $errors[] = 'no_code_found';
            }
            if($errors)
            {
                return Functions::_errorResponse($errors);
            }

            $result = UserPasswordResets::where('token', trim_null_rl($request->input('token')))
                                        ->where('code', trim_null_rl($request->input('code')))
                                        ->update(['status' => 2, 'updated_at' => time()]);

            $result_update_pass = User::where('id',$check_code->uid)->update(['password' => $check_code->password, 'updated_at' => time()]);
            
            if($result_update_pass)
            {
                $user = User::where('email', $check_code->email)->first();
                if($user->password == $check_code->password)
                {
                    $token = JWTAuth::fromUser($user);
                    $request->session()->put('token', $token);
                    $rData->message = 'success';
                    $rData->token = $token;
                    return Functions::_dataResponse($rData);
                }
            }

            return Functions::_errorResponse('fail');
        }
        abort(400, 'Bad request, wrong method.');
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