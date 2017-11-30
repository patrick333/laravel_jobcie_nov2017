<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Redirect;
use Auth;
use App\Tools\ApiErrorResp;

class ValidateUser 
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role='')
    {
        if($role == 'login')
        {
            if ($request->session()->has('token')) 
            {
                return redirect('/home'); 
            }
        }
        if($role == 'user')
        {
            if (!$request->session()->has('token')) 
            {
                return Redirect::route('login','location='.url($_SERVER['REQUEST_URI']));
            }
        }
        
        return $next($request);
    }
}
