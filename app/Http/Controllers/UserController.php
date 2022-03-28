<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //个人页面
    public function setting()
    {
        $title = '个人页面';
        $user = Auth::user();
//        dd($user);
        return view('user/setting', compact('title', 'user'));
    }

    //个人页面设置操作
    public function settingStore(Request $request)
    {
        //验证
        $this->validate(Request(), [
            'name' => 'required|min:1'
        ]);


        $name = $request->input('name');
        $user = Auth::user();

        if ($name == $user->name) {
            return back()->withErrors('无效的用户名');
        }
        if ($name != $user->name) {

            if (User::where('name', $name)->first()) {
                return back()->withErrors('用户名已经被注册');
            }
            $user->name = $name;
        }

        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $user->avatar = '/storage/' . $path;
        }
        //修改
        $user->save();
        return redirect('/posts/');
    }

//    个人中心页面
    public function show(User $user)
    {
        $title = '个人中心页面';
        //这个人的用户信息， 包含关注，粉丝，文章数
//        stars','fans','posts' 调用的是 User模型中的 定义的方法
        $user = User::withCount(['stars','fans','posts'])->find($user->id);

        //这个人的文章列表，取创建时间最新的前10片
        $posts = $user->posts()->orderBy('created_at','desc')->take(10)->get();

        //这个人的关注的用户，包含关注用户的关注、粉丝、文章数
        $stars = $user->stars();
        $susers = User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();

        //这个人的粉丝的用户，包含粉丝用户的关注、粉丝、文章数
        $fans = $user->fans(); //所有粉丝的结果集    pluck(value) ： 返回指定key的值组成的集合
        $fusers = User::whereIn('id',$fans->pluck('fans_id'))->withCount(['stars','fans','posts'])->get();

        return view('user/show',compact('title','posts','susers','fusers','user'));
    }

//   粉操作
    public function fan(User $user)
    {
        $me = Auth::user();
        $me->doFan($user->id);
        return [
            'error' => 0,
            'msg'=>''
        ];
    }

//  取消粉操作
    public function unfan(User $user)
    {
        $me = Auth::user();
        $me->doUnFan($user->id);
        return [
            'error' => 0,
            'msg'=>''
        ];
    }
}
