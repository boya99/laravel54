<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/*
 *
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


//文章列表页
Route::get('/posts','\App\Http\Controllers\PostController@index');
//文章详情页
Route::get('/posts/{post}','\App\Http\Controllers\PostController@show');
//创建文章
Route::get('/posts/create','\App\Http\Controllers\PostController@create');
Route::post('/posts','\App\Http\Controllers\PostController@store');

//编辑文章
Route::get('/posts/{post}/edit','\App\Http\Controllers\PostController@edit');
Route::put('/posts/{post}','\App\Http\Controllers\PostController@update');
//删除文章
Route::get('posts/delete','\App\Http\Controllers\PostController@delete');