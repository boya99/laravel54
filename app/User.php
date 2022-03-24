<?php

namespace App;

use App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
//    不能继承 App/Model 只能自己手动添加

    //允许通过数组注入的字段,需要指定，   白名单
    protected $fillable = [
        'name','email','password'
    ];
}
