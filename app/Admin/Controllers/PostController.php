<?php


namespace App\Admin\Controllers;

use App\Post;
class PostController extends controller
{
    //首页
    public function index(){
        //查询是不需要这个全局scope  avaiable 就使用withOutGlobalScope
        $posts = Post::withOutGlobalScope('avaiable')->where('status',0)->orderBy('created_at','desc')->paginate(5);
        return view('admin/post/index',compact('posts'));
    }
    //具体操作
    public function status(Post $post){
        $this->validate(request(),[
            'status'=>'required|in:1,-1',
        ]);
        $post->status = request('status');
        $post->save();
        //直接return 数组 默认就是json格式
        return [
            'error'=>0,
            'msg'=>''
        ];
    }

}