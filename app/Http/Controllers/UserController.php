<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //个人页面设置
    public function setting(){
        return view('user/setting');
    }

    //个人页面设置操作
    public function settingStore(){
        return ;
    }
}
