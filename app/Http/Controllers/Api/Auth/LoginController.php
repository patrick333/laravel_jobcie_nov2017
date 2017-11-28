<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Tools\Functions;
use App\Tools\ApiErrorResp;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    public function __construct()
    {
        $this->middleware('jwt.auth')->only([
            'logout'
        ]);
    }

    public function postLogin(Request $request)
    {
        //return $this->sendFailedLoginResponse($request);
        //return $this->response->error("User Not Found...", 404);
        //return response()->json(['error' => 'User Not Found...'], 404);
        //return response()->json(ApiErrorResp::responseBadRequest(), 400);
        // $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();

        // if($user && Hash::check($request->get('password'), $user->password)){
        //     $token = JWTAuth::fromUser($user);
            
        //     $this->clearLoginAttempts($request);

        //     return $this->response->array([
        //         'token' => $token,
        //         'status_code' => 200,
        //         'message' => 'User Authenticated'
        //     ]);
        // }

        
        $rData = new \stdClass;
        if ($request->isMethod('post')) {

            $errors = Functions::_validateInput($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required|min:1',
            ]);
            if (!empty($errors)) {
                return Functions::_errorResponse($errors);
            }

            $credentials = $request->only('email', 'password');
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    $errors[] = 'invalid_credentials_401';
                }
            } catch (JWTException $e) {
                Log::error($e->getMessage());
                $errors[] = 'could_not_create_token_500';
            }

            if($errors)
            {
                return Functions::_errorResponse($errors);
            }

            if(compact('token')['token'])
            {
                $request->session()->put('token', compact('token')['token']);
                $rData->message = 'success';
            }
            else
            {
                $rData->message = 'No change';
            }

            return Functions::_dataResponse($rData);
        }
        return response()->json(ApiErrorResp::responseBadRequest(), 400); 
    }

    public function sendFailedLoginResponse(){
        throw new UnauthorizedHttpException("Bad Credentials");
    }

    public function logout(){
        $this->guard()->logout();
    }
 }