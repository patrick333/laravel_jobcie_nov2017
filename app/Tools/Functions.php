<?php

namespace App\Tools;

use Validator;

class Functions {

    /*
    |--------------------------------------------------------------------------
    | Similar to core "trim" but returns null instead of an empty string. When an array is passed, all elements get processed recursively.
    |  * @param string|array $data
    |  * @param null|string  $character_mask
    |  *
    |  * @return array|null|string  去掉左右空格
    |--------------------------------------------------------------------------
    */
    public static function trim_null_rl($data, $character_mask = null)
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



    /*
    |--------------------------------------------------------------------------
    | 返回 JSON
    | Validate request input 验证
    | @param  array  $inputs
    | @param  array  $rules
    | @return array  $errors
    |--------------------------------------------------------------------------
    */
    public static function _validateInput($inputs, $rules) {
        $validator = Validator::make($inputs, $rules);
        
        $errors = array();
        if ($validator->fails()) {
            $messages = $validator->errors();
            foreach ($rules as $key => $value) {
                if ($messages->has($key)) {
                    $errors[$key] = $messages->first($key);
                }
            }
            
        }

        return $errors;
    }

    /*
    |--------------------------------------------------------------------------
    | Generate error json response //错误 JSON
    | @param  array  $errors
    | @return view
    |--------------------------------------------------------------------------
    */
    public static function _errorResponse($errors='') {
        $rData = new \stdClass;
        $rData->status = 1;
        $rData->success = false;
        $rData->errors = $errors;
        return response()->json($rData);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Generate data json response //成功 JSON
    | @param  object  $data
    | @return view
    |--------------------------------------------------------------------------
    */
    public static function _dataResponse($data) {
        $rData = new \stdClass;
        $rData->status = 0;
        $rData->success = true;
        $rData->data = $data;
        return response()->json($rData);
        // return response()->json(array(
        //     'success' => true
        //     'data' => $data,
        // ));
    }

}
