<?php

namespace App;

use App\Model;

//定义用授权
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUsers extends Authenticatable
{
//    后台用户模型
    protected $table = 'admin_users';
    //默认继承的user 表中含有rember_token字段，而 admin_users 表中没有此字段 此时需要重写
    protected $rememberTokenName = '';

//    不允许注入的字段 [] 空数组表示所有字段都可以注入  黑名单
    protected $guarded = [];

    //用户有哪些角色 用户有多个角色，角色有多个用户  多对多关系，使用belongsToMany
    public function roles()
    {
//        参数1 'App\AdminRole' 最终目标model类   参数2 'admin_role_user' 两者中间关系表
//        参数3  'user_id' 中间关系表中跟当前model的(admin_user)外键  参数4 'role_id' 中间关系表中跟目标model的(admin_role)外键
        return $this->belongsToMany(
            'App\AdminRole',
            'admin_role_user',
            'user_id',
//            关系表中的user_id role_id取出来
            'role_id')->withPivot(['user_id', 'role_id']);
    }

    //判断这个用户是否在某个角色，或者某些角色中  $roles 是AdminRole的结果集结合
    public function isInRoles($roles)
    {
        //intersect()  是指 AdminRole的结果集跟 //用户有哪些角色 roles结果集的交集
        return $roles->intersect($this->roles)->count();
    }

    /**
     *  $this->roles  和$this->roles() 区别
     *
     * 加了括号：返回的是模型关联    不加括号返回的是模型关联结果
     */
    //给用户分配角色
    public function assignRole($role)
    {
        // 调用模型中定义的roles()方法，返回的模型关联对象，
        // 自动的进行 对 admin_role_user 进行操作，user_id 使用自身的，role_id 使用传递的$role的id
        return $this->roles()->save($role);
    }

    //取消分配用户的角色
    public function deleteRole($role)
    {
        //并不是删除admin_user和admin_role 而是删除中间 admin_role_user
        return $this->roles()->detach($role);
    }

    //用户是否有权限 参数：$permission 权限对象，
    public function hasPermission($permission){
        //TODO: 用户的角色中的权限 跟 传递的权限是否有交集

        //$permission->roles 权限模型对象调用 权限模型中的roles方法返回的 角色结果集
        //this->isInRoles() 判断当前用户的角色中是否含有此角色
        return $this->isInRoles($permission->roles);
    }
}
