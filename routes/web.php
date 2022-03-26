<?php

/*
默认路由配置
*/

Route::get('/', function () {
    return view('welcome');
});


/*
 *
 注意：路由的命中，跟路由的加载顺序也有关系:
下面第二路由永远访问不到，需要把第二个路由移到上方，才能命中路由
Route::get('/Wap/{post}','[控制器]@[行为]');
Route::get('/Wap/ff','[控制器]@[行为]');


Route::请求方式('路由'，路由回调)
Route::get('/','[控制器]@[行为]');

any 响应任意请求
Route::any('/posts','[控制器]@[行为]');

math 仅限 get,post请求
Route::match(['get', 'post'], '/', function () {
    //
});


Route::put('/posts','[控制器]@[行为]');
表单中 put请求 需要 <input type='hidden' name='_method' value='PUT' />
laravel 提供了简便的方式：{{method_field("PUT")}}

绑定路由参数
Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});
绑定多个路由参数
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
})


group 路由分组 prefix
场景多个路径 都是/posts/users...  /posts/login....  /post/send...
可以进行分组
Route::group(['prefix' => 'posts'], function () {

     Route::get('users', function ()    {
        // 匹配包含 "/posts/users" 的 URL
    });

    Route::post('login', function () {
        // 匹配包含 "/posts/login" 的 URL
    });
});


绑定模型
路由控制器中注入模型 ID 时，我们通常需要查询这个 ID 对应的模型，Laravel 路由模型绑定提供了一个方便的方法自动将模型注入到我们的路由中，
{post}  =>实际是post模型的id
Route::get('/posts/{post}','\app\Http\Controllers\PostController@show');
function show(\app\Post $post){

}

 * */

//----------测试路由案例start----------


Route::get('/test', 'Test\PracticeController@viewtest');
Route::get('/test/md', 'Test\PracticeController@moreData');
Route::get('/test/cr', 'Test\PracticeController@compactRoute');

//----------测试路由案例end----------

//用户模块
//用户注册页面
Route::get('/register', '\App\Http\Controllers\RegisterController@index');
//用户注册行为
Route::post('/register', '\App\Http\Controllers\RegisterController@register');
//登录页面
Route::get('/login', '\App\Http\Controllers\LoginController@index')->name('login');
//登录行为
Route::post('/login', '\App\Http\Controllers\LoginController@login');


//路由分配中间件，可以在路由组中使用 middleware 键
//使用 `Auth` 中间件 路由鉴权不成功，自动寻找login的路由，前提login是 命名的路由
Route::group(['middleware' => 'auth:web'], function () {
//登出行为
    Route::get('/logout', '\App\Http\Controllers\LoginController@logout');
//个人设置
    Route::get('/user/me/setting', '\App\Http\Controllers\UserController@setting');
//个人设置操作
    Route::post('/user/me/setting', '\App\Http\Controllers\UserController@settingStore');


//文章列表页 指定控制器，默认情况下是在app/Http/Controllers/寻找postController
    Route::get('/posts', 'PostController@index');
//创建文章
    Route::get('/posts/create', 'PostController@create');
    Route::post('/posts', '\App\Http\Controllers\PostController@store');

//文章详情页 实际路由url 传递是post表的id post指定的是模型绑定，绑定 app\post.php模型 对应的表名 posts
    Route::get('/posts/{post}', '\App\Http\Controllers\PostController@show');


//编辑文章
    Route::get('/posts/{post}/edit', '\App\Http\Controllers\PostController@edit');
//编辑操作传递模型
    Route::put('/posts/{post}', '\App\Http\Controllers\PostController@update');
//删除文章 传递模型
    Route::get('posts/{post}/delete', '\App\Http\Controllers\PostController@delete');
//图片上传路由
    Route::post('/posts/image/upload', '\App\Http\Controllers\PostController@imageUpload');
//    提交评论
    Route::post('/posts/{post}/comment', 'PostController@comment');
//  点赞
    Route::get('/posts/{post}/zan', 'PostController@zan');
//    取消赞
    Route::get('/posts/{post}/unzan', 'PostController@unzan');
});

