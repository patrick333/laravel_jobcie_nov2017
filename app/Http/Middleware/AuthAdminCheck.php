<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Redirect;
use Auth;
use App\Tools\ApiErrorResp;

class AuthAdminCheck
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
     * 保护路由 'middleware' => 'admin',  验证是否登录//后台
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (!Auth::user()->is_admin) {
                if ($request->ajax()) {
                    return response()->json(ApiErrorResp::responseUnauthorized(), 401);
                }
                session()->flash('message_warning', '您不是管理员！无法进入相关区域');
                return redirect()->route('login');
            }
		} else {
            if ($request->ajax()) {
                return response()->json(ApiErrorResp::responseUnauthorized(), 401);
            }
            if(!empty($request->input('time')))
            {
                return response()->json(ApiErrorResp::responseUnauthorized(), 401);
            }
            //return redirect('/admin/login?location='.$request->url()); //默认
            //return Redirect::route('admin_login_route','location='.$request->url());
            return Redirect::route('login','location='.url($_SERVER['REQUEST_URI']));
		}
		return $next($request);
    }
}
