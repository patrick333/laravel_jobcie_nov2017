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
use Tymon\JWTAuth\Facades\JWTGuard;
use Auth;

use App\Tools\Functions;
use App\Tools\ApiErrorResp;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    public function __construct()
    {
        $this->middleware('jwt.auth')->only([
            'postLogout'
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
        //     $user = JWTAuth::toUser($token);
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
                'email' => 'required|max:255',
                'password' => 'required|min:1',
            ]);
            if (!empty($errors)) {
                return Functions::_errorResponse($errors);
            }
            
            $conditions_email = [
                'email'=>$request->input('email'),
                'password'=>$request->input('password'),
            ];
            $conditions_username = [
                'username'=>$request->input('email'),
                'password'=>$request->input('password'),
            ];

            try 
            {
                if (!$token = JWTAuth::attempt($conditions_email)) 
                {
                    if (!$token = JWTAuth::attempt($conditions_username)) 
                    {
                        $errors[] = 'wrong_username_or_password';
                    }
                }
            } catch (JWTException $e) 
            {
                Log::error($e->getMessage());
                $errors[] = 'could_not_create_token';
            }

            if($errors)
            {
                return Functions::_errorResponse($errors);
            }

            if($token)
            {
                $this->clearLoginAttempts($request);
                $request->session()->put('token', $token);
                $rData->message = 'success';
                $rData->token = $token;

                return Functions::_dataResponse($rData);
            }
            return Functions::_errorResponse('fail');
        }
        abort(400, 'Bad request, wrong method.'); 
    }

    public function postRefershToken(Request $request)
    {
        $rData = new \stdClass;
        if ($request->isMethod('post')) 
        {
            if (! JWTAuth::parser()->setRequest($request)->hasToken()) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token not provided');
            }

            $token = Auth::guard('api')->refresh();

            //or
            // try {  
            //     $old_token = JWTAuth::getToken();  
            //     $token = JWTAuth::refresh($old_token);
            //     JWTAuth::invalidate($old_token);  
            // } catch (TokenExpiredException $e) {  
            //     throw new AuthException(  
            //         Constants::get('error_code.refresh_token_expired'),  
            //         trans('errors.refresh_token_expired'), $e);  
            // } catch (JWTException $e) {  
            //     throw new AuthException(  
            //         Constants::get('error_code.token_invalid'),  
            //         trans('errors.token_invalid'), $e);  
            // }  

            $rData = new \stdClass;
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

    public function postLogout(Request $request)
    {
        $request->session()->flush();
        Auth::guard('api')->logout();
        //or
        //JWTAuth::invalidate(JWTAuth::getToken());
        
        $rData = new \stdClass;
        $rData->message = 'success';
        $rData->token = '';
        return Functions::_dataResponse($rData);
    }

    public function sendFailedLoginResponse(){
        throw new UnauthorizedHttpException("Bad Credentials");
    }
 }