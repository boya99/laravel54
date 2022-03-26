<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //个人页面
    public function setting(){
        $title = '个人页面';
        $user = Auth::user();
//        dd($user);
        return view('user/setting',compact('title','user'));
    }

    //个人页面设置操作
    public function settingStore(Request $request){
        //验证
        $this->validate(Request(),[
            'name'=>'required|min:1'
        ]);


        $name = $request->input('name');
        $user = Auth::user();

        if($name == $user->name){
            return back()->withErrors('无效的用户名');
        }
        if($name != $user->name){

            if(User::where('name',$name)->first()){
                return back()->withErrors('用户名已经被注册');
            }
            $user->name = $name;
        }

        if($request->file('avatar')){
            $path = $request->file('avatar')->store('avatars');
            $user->avatar = '/storage/'.$path;
        }
        //修改
        $user->save();
        return  redirect('/posts/');
    }
}
