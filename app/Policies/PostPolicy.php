<?php
//php artisan make:policy PostPolicy    生成post鉴权策略类,生成后需要注册策略
namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

//    post修改权限 文章能不能被用户更新
    public function update(User $user,Post $post){
        return $user->id == $post->user_id;
    }
    //post删除权限
    public function delete(User $user,Post $post){
        return $user->id == $post->user_id;
    }

    /**
     * 判断给定用户是否可以创建博客。
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        //
    }
}
