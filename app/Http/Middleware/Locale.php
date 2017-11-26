<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;
use App;

class Locale {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->input('lang') == 'en') {
            $request->session()->put('locale', 'en');
        } else if ($request->input('lang') == 'zh_cn') {
            $request->session()->put('locale', 'zh_cn');
        }

        App::setLocale(session('locale'));

        return $next($request);
    }
}
