<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | The database table used by the model.  @var string
    |--------------------------------------------------------------------------
    */
    protected $table = 'user';

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

    /*
    |--------------------------------------------------------------------------
    | http://www.golaravel.com/laravel/docs/5.0/eloquent/#mass-assignment 支持批量赋值 白名单
    | The attributes that are mass assignable. @var array
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['id','username', 'email', 'password', 'login_ip'];
    protected $guarded = []; //黑名单
    /*
    |--------------------------------------------------------------------------
    | 转换成数组或 JSON 时隐藏属性。
    | The attributes excluded from the model's JSON form. @var array
    |--------------------------------------------------------------------------
    */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|unique:user',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|min:6',
        ]);
    }

    protected static function create_array($request)
    {
        $array = [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'login_ip' => getIPaddress(),
        ];
        return $array;
    }
}
