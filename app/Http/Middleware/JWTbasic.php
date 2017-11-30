<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Illuminate\Http\Request;
use App\Client;  

class JWTbasic
{
    use Helpers;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role='')
    {
        if($role == 'session')
        {
            // if (!$request->ajax()) {
            //     abort(400, 'Bad request, not AJAX request.');
            // }
            
            request()->headers->set('Authorization','Bearer '.$request->session()->get('token'));

            return $next($request);
        }
        if($role == 'admin')
        {
            // $user = $this->auth->user()->is_admin;
            // dd($user);
            // try {

            //     if (! $user = JWTAuth::parseToken()->authenticate()) {
            //         return response()->json([
            //             'errcode' => 400004,
            //             'errmsg' => 'user not found'
            //         ], 404);
            //     }

            // } catch (TokenExpiredException $e) {

            //     return response()->json([
            //         'errcode' => 400001,
            //         'errmsg' => 'token expired'
            //     ], $e->getStatusCode());

            // } catch (TokenInvalidException $e) {

            //     return response()->json([
            //         'errcode' => 400003,
            //         'errmsg' => 'token invalid'
            //     ], $e->getStatusCode());

            // } catch (JWTException $e) {

            //     return response()->json([
            //         'errcode' => 400002,
            //         'errmsg' => 'token absent'
            //     ], $e->getStatusCode());

            // }
            return $next($request);
        }
        return $next($request);
    }
}
