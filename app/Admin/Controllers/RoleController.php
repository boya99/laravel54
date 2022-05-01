<?php
namespace App\Admin\Controllers;

use App\AdminPermission;
use App\AdminRole;
use App\AdminUsers;
class RoleController extends controller
{
    //角色展示页面
    public function index()
    {
        $roles = AdminRole::paginate(10);
        return view('admin/role/index',compact('roles'));

    }
    //角色创建页面
    public function create()
    {
        return view('admin/role/add');
    }
    //角色创建操作
    public function store()
    {
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required',

        ]);
        //创建角色
        AdminRole::create(request(['name','description']));
        return redirect('admin/roles');

    }
    //角色权限页面
    public function permission(AdminRole $role)
    {
        //获取所有权限
        $permissions = AdminPermission::all();
        //获取当前所有角色权限
        $myPermissions = $role->permissions;

        return view('admin/role/permission',compact('permissions','myPermissions','role'));
    }
    //角色权限修改
    public function storePermission(AdminRole $role)
    {
        $this->validate(request(),[
            'permissions'=>'required|array'
        ]);
        $permissions = AdminPermission::findMany(request('permissions'));

        $myPermissions = $role->permissions;

        //对，已有的权限
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $addPermission){
            $role->grantPermission($addPermission);
        }

        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $deletePermission){
            $role->deletePermission($deletePermission);
        }

//        return back();
        return redirect('admin/roles');
    }

}