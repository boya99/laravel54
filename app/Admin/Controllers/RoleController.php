<?php
namespace App\Admin\Controllers;

use App\AdminUsers;
class RoleController extends controller
{
    //角色展示页面
    public function index()
    {
        return view('admin/role/index');

    }
    //角色创建页面
    public function create()
    {
        return view('admin/role/add');
    }
    //角色创建操作
    public function store()
    {

    }
    //角色权限页面
    public function permission()
    {
        return view('admin/role/permission');
    }
    //角色权限修改
    public function storePermission()
    {

    }

}