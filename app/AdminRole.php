<?php

namespace App;

//继承当前文件下的Model文件
class AdminRole extends Model
{
    //角色模型
    protected $table = 'admin_roles';

    //获取角色的所有权限  多对多
    public function permissions()
    {
        return $this->belongsToMany(
            'App\AdminPermissions',
            'admin_permission_role',
            'role_id',
            'permission_id'
//         withPivot   关联表中关系也取出来
        )->withPivot(['role_id', 'permission_id']);
    }

    //角色赋予权限
    public function grantPermission($permission)
    {
        //$this->permissions()  调用模型关联返回关联对象
        return $this->permissions()->save($permission);
    }

    //角色 取消权限
    public function deletePermission($permission){
        //$this->permissions() 调用模型关联返回关联对象  detach 删除中间关系表
        return $this->permissions()->detach($permission);
    }

    //判断角色是否有权限
    public function hasPermission($permission){
        //$this->permissions 调用返回关联模型结果集  contains($permission)是否有 $permission 对象
        return $this->permissions->contains($permission);
    }
}
