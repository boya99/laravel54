<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //登录页面
    public function index(){
//        如果已经登录，直接跳转页面
        if(Auth::check()){
            return \redirect('/posts');
        }
        return view('login/index');
    }
//    登录行为
    public function login(Request $request){
        //验证
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required',
            'is_remember'=>'integer'
        ]);
        //逻辑
        $user = $request->only(['email','password']);
        $is_remember =  $request->input('is_remember') ;

//        Log::info('aaa',['name'=>'zhangsa','age'=>18]);
    /*

    if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
        // 这个用户被记住了...
    }
            第一个参数 为 一个数组
            通过 email 字段被取出，如果用户被找到了，数据库里经过哈希的密码将会与数组中哈希的 password 值比对
            如果认证成功，attempt 方法将会返回 true，反之则为 false。

            第二个参数 为一个 布尔值
            需写第二个参数 要提供「记住我」的功能
            users 数据表一定要包含一个 remember_token 字段，这是用来保存「记住我」令牌的
    */

        if (Auth::attempt(['email' => $user['email'], 'password' => $user['password']], $is_remember)) {
            // 这个用户被记住了...
            return redirect('/posts');
        }
//        if(Auth::attempt($user,$is_remember)){
//            return redirect('/posts');
//        }


        //渲染
        return Redirect::back()->withErrors('邮箱密码不匹配');
    }

    //登出行为
    public function logout(){
        \auth()->logout();
        return redirect('/');
    }

    public function welcome(){
        return redirect('/login');
    }
}
