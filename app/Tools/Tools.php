<?php

use App\User;

/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
*/
if (! function_exists('site_path'))
{
    function site_path() 
    { 
        return config('app.directory', 'www');
        //return Config::get('base.directory'); 
    }
}


if(! function_exists('is_json'))
{
    function is_json($string) 
    { 
        
    }
}




