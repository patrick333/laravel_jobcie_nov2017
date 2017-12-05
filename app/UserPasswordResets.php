<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPasswordResets extends Model
{
    /*
    |--------------------------------------------------------------------------
    | The database table used by the model.  @var string
    |--------------------------------------------------------------------------
    */
    protected $table = 'user_password_resets';

    /*
    |--------------------------------------------------------------------------
    | created_at  updated_at  Enable or Disable  U 时间戳
    |--------------------------------------------------------------------------
    */
    public $timestamps = true;
    protected function getDateFormat()
    {
        return 'U';
    }
    
    /*
    |--------------------------------------------------------------------------
    | 软删除方式删除
    |--------------------------------------------------------------------------
    */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected static function _genCode() 
    {
        $code_list = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

        //code is 6 digits
        $rand_key = array_rand($code_list, 6);
        $code = '';
        foreach ($rand_key as $c) 
        {
            $code .= $code_list[$c];
        }
        return $code;
    }
}
