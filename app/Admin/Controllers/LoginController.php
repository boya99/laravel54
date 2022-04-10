<?php

namespace App\Admin\Controllers;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends controller
{
//    登录展示页
    public function index()
    {
        return view('admin/login/index');
    }

    //    登录行为
    public function login()
    {
        $this->validate(\request(),[
            'name'=>'required|min:2',
            'password'=>'required|min:3|max:10'
        ]);
        $user = \request(['name','password']);
        //用户登录存储 指定守卫：guard 守卫为admin
        if(Auth::guard('admin')->attempt($user)){
            //登录成功跳转
            return redirect('/admin/home');
        }else{
            return  Redirect::back()->withErrors('用户密码不正确');
        }

    }

    //    登出行为
    public function logout()
    {
        //指定admin 守卫进行登出
        Auth::guard('admin')->logout();
        return redirect('/admin/login');

    }

}