<?php

namespace App\Tools;
use DB;

class ApiErrorResp {

    const CODE_BAD_REQUEST = 100;
    const CODE_UNAUTHORIZED = 101;
    const CODE_NOT_FOUND = 104;
    const CODE_METHOD_NOT_ALLOWED = 105;

    const MSG_BAD_REQUEST = 'Bad request';
    const MSG_UNAUTHORIZED = 'Unauthorized';
    const MSG_NOT_FOUND = 'API not found';
    const MSG_METHOD_NOT_ALLOWED = 'Method not allowed';
    
    /**
     * Get cities by parent id
     *
     * @param  int  $parent_id
     * @return mixed
     */
    public static function responseBadRequest($message = false) {
        $resp = new \stdClass;
        $resp->status = 1;
        $resp->success = false;
        $resp->error = new \stdClass;
        $resp->error->code = self::CODE_BAD_REQUEST;
        $resp->error->message = self::MSG_BAD_REQUEST;
        if ($message) {
            $resp->error->message = $message;
        }
        
        return $resp;
    }

    public static function responseUnauthorized() {
        $resp = new \stdClass;
        $resp->status = 1;
        $resp->success = false;
        $resp->error = new \stdClass;
        $resp->error->code = self::CODE_UNAUTHORIZED;
        $resp->error->message = self::MSG_UNAUTHORIZED;
        
        return $resp;
    }

    public static function responseNotFound() {
        $resp = new \stdClass;
        $resp->status = 1;
        $resp->success = false;
        $resp->error = new \stdClass;
        $resp->error->code = self::CODE_NOT_FOUND;
        $resp->error->message = self::MSG_NOT_FOUND;
        
        return $resp;
    }

    public static function responseMethodNotAllowed() {
        $resp = new \stdClass;
        $resp->status = 1;
        $resp->success = false;
        $resp->error = new \stdClass;
        $resp->error->code = self::CODE_METHOD_NOT_ALLOWED;
        $resp->error->message = self::MSG_METHOD_NOT_ALLOWED;
        
        return $resp;
    }

}