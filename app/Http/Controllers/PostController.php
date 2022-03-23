<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //列表页
    public function index(){
        $title = '列表页';
//        paginate 简单分页逻辑
        $posts = Post::orderBy('created_at','desc')->paginate(6);

        return view('post/index',compact('title','posts'));
    }

    //文章详情页 路由直接传递数据模型 参数是 post 模型
    public function show(Post $post){
        $title = '文章详情页';
        return view('post/show',compact('title','post'));
    }

    //创建文章
    public function create(){
        $title = '创建文章';
        return view('post/create' ,compact('title'));
    }
    //创建文章
    public function store(){

//        dd(Request::capture()->all());
//        打印所有请求 上述命令效果一致
//        dd(request()->all());

//        $title = \request('title'); //获取单个参数
//        $info = request()->all();//获取所有请求
        //跟在 tinker 中命令一致，添加数据到数据库
//        $post = new Post();
//        $post->title = $info['title'];
//        $post->content = $info['content'];
//        $post->save();

//       1.表单验证 当验证失败的时候被重定向到原来的控制器层中，并且渲染了$errors 这个实例
        $this->validate(\request(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:5',
        ]);



        // 2.业务逻辑 Post模型提供create() 方法，参数是数组，也能添加
//        $params = ['title'=>$info['title'],'content'=>$info['content']];
        //简写形式 跟上述一致，前提：字段名 跟数据表的字段名一致，且提交的参数名也一致
        $params = \request(['title','content']);
        $post = Post::create($params);

//      3.页面渲染或者路由重定向 到posts中
        return redirect("/posts");
//        dd($post);
    }
    //编辑文章
    public function edit(){
        $title = '编辑文章';
        return view('post/edit',compact('title'));
    }
    //编辑文章
    public function update(){

    }
    //删除文章
    public function delete(){

    }

//    图片上传
    public function imageUpload(Request $request){
        dd($request->all());
    }
}
