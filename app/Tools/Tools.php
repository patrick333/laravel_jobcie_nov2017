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

/*
|--------------------------------------------------------------------------
| 发送post请求 get or post
| @param string $url 请求地址 
| @param array $post_data post键值对数据 
| @return string
|--------------------------------------------------------------------------
*/
if(! function_exists('request_by_curl'))
{
    function request_by_curl($url, $post_data = array(), $post = true, $connectTimeout = null, $readTimeout = null) {  
        if(is_array($post_data))
        {
            $post_data = http_build_query($post_data);
        }
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        if($post)
        {
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        if ($readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $readTimeout);
        }
        if ($connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        }
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        $file_contents = curl_exec($ch);
        if (curl_errno($ch)) 
        {
            curl_close($ch);
            return $ch;
        }
        curl_close($ch);
        return $file_contents;
    }  
}

/*
|--------------------------------------------------------------------------
| 获取客户端真实IP地址
|--------------------------------------------------------------------------
*/
if (! function_exists('getIPaddress'))
{
    function getIPaddress()
    {
        $IPaddress='';
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $IPaddress = $_SERVER["REMOTE_ADDR"];
            }

        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $IPaddress = getenv("HTTP_CLIENT_IP");
            } else {
                $IPaddress = getenv("REMOTE_ADDR");
            }
        }
        return $IPaddress;
    }
}

/*
|--------------------------------------------------------------------------
| Similar to core "trim" but returns null instead of an empty string. When an array is passed, all elements get processed recursively.
|  * @param string|array $data
|  * @param null|string  $character_mask
|  *
|  * @return array|null|string  去掉左右空格
|--------------------------------------------------------------------------
*/
if (! function_exists('trim_null_rl'))
{
    function trim_null_rl($data, $character_mask = null)
    {
        if (!is_array($data)) {
            return null === $character_mask ? trim($data) : trim($data, $character_mask) ?: null;
        }

        return array_map(
            function ($value) use ($character_mask) {
                return trim_null_rl($value, $character_mask);
            },
            $data
        );
    }
}  


