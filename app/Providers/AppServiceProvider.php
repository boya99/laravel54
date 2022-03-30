<?php

namespace App\Providers;

use App\Topic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //启动前
        Schema::defaultStringLength(191);

//        公共页面传值 使用view::composer('模板','回调方法')
        View::composer('layout.sidebar',function($view){
            $topics = Topic::all();
            $view->with('topics',$topics);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //启动后
    }
}
