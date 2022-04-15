<?php

namespace App;

//继承当前文件下的Model文件
class AdminPermission extends Model
{
    //权限模型
    protected $table = 'admin_permissions';
    //权限属于哪个角色  权限有多个角色，角色有多个权限
    public function roles(){
        return $this->belongsToMany('App\AdminRole','admin_permission_role','permission_id','role_id')
            ->withPivot(['permission_id','role_id']);
    }
}
