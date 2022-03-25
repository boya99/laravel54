<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * 应用的策略映射
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
//     模型文件     =>指向鉴权模型
        'App\Post' =>'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * 注册任意用户认证、用户授权服务
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
