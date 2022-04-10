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
    });

});