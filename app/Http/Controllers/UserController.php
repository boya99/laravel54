<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //个人页面
    public function setting(){
        $title = '个人页面';
        return view('user/setting',compact('title'));
    }

    //个人页面设置操作
    public function settingStore(){
        return ;
    }
}
