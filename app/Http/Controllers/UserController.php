<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

	public function __construct()
    {
        
    }

    public function getIndex(Request $request)
    {
    	dd($request->session()->get('token'));
        return view('home.index');
    }
}
