<?php
namespace App\Admin\Controllers;

use App\AdminUsers;
class PermissionController extends controller
{
    //权限展示页面
    public function index()
    {
        return view('admin/permission/index');
    }

    //权限创建页面
    public function create()
    {
        return view('admin/permission/add');

    }
    //权限创建操作
    public function store(){

    }


}