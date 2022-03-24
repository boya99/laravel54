<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //注册页面
    public function index(){
        return view('register/index');
    }
//    注册行为
    public function register(){
        //验证
        $this->validate(\request(),[
//            unique:table,column   //table表中column字段唯一
            'name'=>'required|min:3|unique:users,name',
            'email'=>'required|unique:users,email|email',
//            验证的字段是 password，就必须和输入数据里的 password_confirmation 的值保持一致。直接：confirmed
            'password'=>'required|unique:users,email|confirmed',
        ]);
        //逻辑
        $name = \request('name');
        $email = \request('email');
//        bcrypt 自定义加密
        $password = bcrypt(\request('password')) ;
//        使用create 批量赋值，需要在model层定义一个 fillable 或 guarded 属性
        $res = User::create(compact('name','email','password'));
        //渲染
        return view('/login/index');
    }
}
