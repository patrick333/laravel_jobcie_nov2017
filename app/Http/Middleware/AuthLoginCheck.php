<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Redirect;
use Auth;
use App\Tools\ApiErrorResp;

class AuthLoginCheck 
{
	/**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     * 安全验证用户是否登录 'middleware' => 'login', //type check is_admin   .... login 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            if (Auth::user()->is_admin) {
                return new RedirectResponse(url('/admin/index'));
            } else {
                return redirect('/user'); //默认
            }
            //return redirect('/home'); //默认
        }
        return $next($request);
    }
}
