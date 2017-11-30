<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

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

    public function getSignup(Request $request)
    {
        return view('auth.signup');
    }

    public function getLogout(Request $request)
    {
        // delete api token
        //$result = $this->_post(url('/api/logout'), $request->session()->get('token'));
        $result = $this->_get(url('/api/logout'), $request->session()->get('token'));
        
        // delete web token
        $request->session()->flush();
        return Redirect::route('login');
    }

    private function _get($url, $token) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ));
        
        $response = curl_exec($ch);

        $result = $this->_check_curl_response($ch);
        if ($result === false) {
            //throw new \Exception($response);
        }

        $data = json_decode($response);
        return $data;
    }

    private function _post($url, $post_data, $token=false) {
        $ch = curl_init();

        $post_data_json = json_encode($post_data);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($token) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$token,
                'Content-Length: ' . strlen($post_data_json))
            );
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data_json))
            );
        }

        $response = curl_exec($ch);
        $result = $this->_check_curl_response($ch);
        if ($result === false) {
            //throw new \Exception($response);
        }
        curl_close($ch);
        return $response;
    }
    private function _check_curl_response($ch) {
        if (!curl_errno($ch)) {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($http_code != 200 && $http_code != 202 && $http_code != 203 && $http_code != 201 && $http_code != 204) {
                return false;
            }
            return $http_code;
        } else {
            throw new \Exception('curl error: '.curl_error($ch));
        }
    }
}
