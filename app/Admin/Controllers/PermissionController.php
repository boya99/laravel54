<?php
namespace App\Admin\Controllers;

use App\AdminPermission;
use App\AdminUsers;
class PermissionController extends controller
{
    //权限展示页面
    public function index()
    {
        $permissions = AdminPermission::paginate(10);
        return view('admin/permission/index',compact('permissions'));
    }

    //权限创建页面
    public function create()
    {
        return view('admin/permission/add');

    }
    //权限创建操作
    public function store(){

        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required'
        ]);
        AdminPermission::create(request(['name','description']));
        return redirect('admin/permissions');
    }


}