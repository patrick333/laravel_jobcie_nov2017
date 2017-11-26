<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        //return $this->response->error("User Not Found...", 404);
        //return response()->json(['error' => 'User Not Found...'], 404);

        // $credentials = $request->only('email', 'password');
        // try {
        //     // attempt to verify the credentials and create a token for the user
        //     if (! $token = JWTAuth::attempt($credentials)) {
        //         return response()->json(['error' => 'invalid_credentials'], 401);
        //     }
        // } catch (JWTException $e) {
        //     // something went wrong whilst attempting to encode the token
        //     return response()->json(['error' => 'could_not_create_token'], 500);
        // }

        // // all good so return the token
        // return response()->json(compact('token'));
        // dd('1');

        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();

        if($user && Hash::check($request->get('password'), $user->password)){
            $token = JWTAuth::fromUser($user);
            return $this->sendLoginResponse($request, $token);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function sendLoginResponse(Request $request, $token){
        $this->clearLoginAttempts($request);

        return $this->authenticated($token);
    }

    public function authenticated($token){
        return $this->response->array([
            'token' => $token,
            'status_code' => 200,
            'message' => 'User Authenticated'
        ]);
    }

    public function sendFailedLoginResponse(){
        throw new UnauthorizedHttpException("Bad Credentials");
    }

    public function logout(){
        $this->guard()->logout();
    }
 }