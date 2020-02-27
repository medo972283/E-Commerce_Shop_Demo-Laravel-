<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

class Customer extends Model 
{
    // use Notifiable;
    
    //資料表名稱
    protected $table = 'customer';
    
    //主鍵名稱
    protected $promaryKey = 'id';

    //可以大量指定異動的欄位(Mass Assignment)
    protected $fillable = [
        'nickname', 'email', 'account', 'password',
    ];




    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
