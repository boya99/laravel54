<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use App\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct()
    {
        $user = Auth::user();

    }

    //列表页
    public function index()
    {
        $user = Auth::user();
        $title = '列表页';
//        paginate 简单分页逻辑    withCount(['a','b'])  a,b 统计多个，a,b指的是 模型中关联的方法
        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments','zans'])->paginate(6);

        return view('post/index', compact('title', 'posts', 'user'));
    }

    //文章详情页 路由直接传递数据模型 参数是 post 模型
    public function show(Post $post)
    {
        $title = '文章详情页';

//        $post->load('comments');//预加载 加载完控制器已读取数据，然后渲染模板。遵循mvc三层规则
        $comments = $post->comments()->get();//当前文章模型关联 comments 模型的内容
//        with是加载所有文章下的 的comments
//        $comments2 = $post->with('comments')->get();

        $post->load('comments');
        return view('post/show', compact('title', 'post'));
    }

    //创建文章
    public function create()
    {
        $title = '创建文章';
        $user = Auth::user();
        return view('post/create', compact('title', 'user'));
    }

    //创建文章
    public function store()
    {

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
        $this->validate(Request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:5',
        ]);


        //验证是否具有修改的权限
        $this->authorize('create', Post::class);

        $user_id = Auth::id();//用户id
        // 2.业务逻辑 Post模型提供create() 方法，参数是数组，也能添加
//        $params = ['title'=>$info['title'],'content'=>$info['content']];
        //简写形式 跟上述一致，前提：字段名 跟数据表的字段名一致，且提交的参数名也一致
        $params = Request(['title', 'content']);
        $ar = array_merge($params, compact('user_id'));
        $post = Post::create($ar);

//      3.页面渲染或者路由重定向 到posts中
        return redirect("/posts");
//        dd($post);
    }

    //编辑文章 传递模型
    public function edit(Post $post)
    {
        $title = '编辑文章';
        $user = Auth::user();
        return view('post/edit', compact('title', 'post', 'user'));
    }

    //编辑文章 传递表单模型
    public function update(Post $post)
    {
//       1.表单验证 有表单验证，页面就有$errors 实例
        $this->validate(\request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:5',
        ]);

        //权限验证 是否有update权限
        $this->authorize('update', $post);


//        $this->can('update',$post);

        //逻辑操作
        $post->title = \request('title');
        $post->content = \request('content');
        $post->save();//更新操作


        //渲染
        return redirect("/posts/{$post->id}");

    }

    //删除文章
    public function delete(Post $post)
    {
        //TODO 用户验证
        //权限验证 是否有delete权限
        $this->authorize('delete', $post);
        return redirect('/posts');
    }

//    图片上传
    public function imageUpload(Request $request)
    {
        //file('上传文件名')获取文件
        // storePublicly(自定义文件名方法)，自带扩展名，缺点不能指定目录
//        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));


//        storeAs('路径','文件名.扩展名');都要带上
//        $path = $request->file('wangEditorH5File')->storeAs(
//            'avatars',md5(time())
//        );


//        store('上传路径');   会自己生成唯一的id文件名
        $path = $request->file('wangEditorH5File')->store('uploads');
//        asset 来创建文件的 URL：
        return asset('storage/' . $path);

    }


    public function comment(Post $post)
    {
        $this->validate(\request(), [
            'content' => 'required|min:2'
        ]);
        //逻辑

        $comment = new Comment();//comment实例模型
        $comment->user_id = Auth::id();
        $comment->content = \request('content');//获取提交的content
//        通过反向关联 写入关联模型 提交comment
        $post->comments()->save($comment);//提交
        //渲染
        return back();
    }

//    点赞
    public function zan(Post $post)
    {
        $param = [
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ];
//        firstOrCreate 方法将会使用指定的字段／值对，来尝试寻找数据库中的记录。如果在数据库中找不到模型，则会使用指定的属性来添加一条记录。
//        是否存在，存在就查找，不在就插入
        Zan::firstOrCreate($param);
        return back();
    }

//  搜索结果页
    public function search()
    {
        $title = '搜索结果页';
        //验证
        $this->validate(\request(),[
            'query'=>'required'
        ]);
        //逻辑
        $query = \request('query');
//        $posts = Post::search($query)->get();
        $posts = Post::search($query)->paginate(2);//使用分页
        return \view('Post/search',compact('title','posts','query'));
    }

//  取消赞
    public function unzan(Post $post)
    {
        $zanInfo = $post->zan(Auth::id());//获取这篇文章这个用户的赞的 实例
        $zanInfo->delete();//赞的实例 进行删除操作

        return back();
    }
}
