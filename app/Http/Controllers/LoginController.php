<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

	public function __construct()
    {
        // view()->composer('widgets.bootstrapCategory', function ($view) use ($categories) {
        //     $view->with('categories', $categories);
        // }); 
    }

    public function getLogin(Request $request)
    {
        return view('auth.login');
    }
}
