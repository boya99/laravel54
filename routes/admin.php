<?php

//admin 后台路由

Route::group(['prefix'=>'admin'],function(){
    //登录展示页面
    Route::get('/login','\App\Admin\Controllers\LoginController@index');
    //登录行为
    Route::post('/login','\App\Admin\Controllers\LoginController@login');
    //登出行为
    Route::get('/logout','\App\Admin\Controllers\LoginController@logout');
    //增加用户鉴权才可以登录到首页 表示使用laravel 的auth.php配置文件，再指向guards 守卫为 admin
    Route::group(['middleware'=>'auth:admin'],function(){
        //后台首页
        Route::get('/home','\App\Admin\Controllers\HomeController@index');
        //管理人员模块
        Route::get('/users','\App\Admin\Controllers\UserController@index');
        //管理员添加页面
        Route::get('/users/create','\App\Admin\Controllers\UserController@create');
        //管理员添加操作
        Route::post('/users/store','\App\Admin\Controllers\UserController@store');
        //用户展示角色页面
        Route::get('/users/{user}/role','\App\Admin\Controllers\UserController@role');
        //用户添加角色操作
        Route::post('/users/{user}/role','\App\Admin\Controllers\UserController@storeRole');

        //角色展示页面
        Route::get('/roles','\App\Admin\Controllers\RoleController@index');
        //角色创建页面
        Route::get('/roles/create','\App\Admin\Controllers\RoleController@create');
        //角色创建操作
        Route::post('/roles/store','\App\Admin\Controllers\RoleController@store');
        //角色权限页面
        Route::get('/roles/{role}/permission','\App\Admin\Controllers\RoleController@permission');
        //角色权限修改
        Route::post('/roles/{role}/permission','\App\Admin\Controllers\RoleController@storePermission');

        //权限展示页面
        Route::get('/permissions','\App\Admin\Controllers\PermissionController@index');
        //权限创建页面
        Route::get('/permissions/create','\App\Admin\Controllers\PermissionController@create');
        //权限创建操作
        Route::post('/permissions/store','\App\Admin\Controllers\PermissionController@store');


        //审核模块
        Route::get('/posts','\App\Admin\Controllers\PostController@index');
        Route::post('/posts/{post}/status','\App\Admin\Controllers\PostController@status');
    });

});