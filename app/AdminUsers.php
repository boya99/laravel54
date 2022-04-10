<?php

namespace App;

use App\Model;
//定义用授权
use Illuminate\Foundation\Auth\User as Authenticatable;
class AdminUsers extends Authenticatable
{
    //默认继承的user 表中含有rember_token字段，此时需要重写
    protected $rememberTokenName = '';

//    不允许注入的字段 [] 空数组表示所有字段都可以注入  黑名单
    protected $guarded = [];
}
