<?php
namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUsers;
class UserController extends controller
{
    //管理员列表页面
    public function index()
    {
        $users = AdminUsers::paginate(10);
        return view('admin/user/index',compact('users'));
    }

    //管理员创建页面
    public function create()
    {

        return view('admin/user/add');
    }
    //创建操作
    public function store(){
        $this->validate(\request(),[
            'name'=>'required|min:2',
            'password'=>'required|min:3',
        ]);
        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUsers::create(compact('name','password'));
        return redirect('admin/users');
    }

    //用户展示角色页面
    public function role(AdminUsers $user)
    {
        //1.展示所有的角色
        $roles = AdminRole::all(); //所有的角色
        //2.查看我的角色 调用AdminUser model 中的roles方法  不带（） 返回的是结果集
        $myRole = $user->roles;
        return view('admin/user/role',compact('roles','myRole','user'));

    }
    //用户添加角色操作
    public function storeRole(AdminUsers $user)
    {
        $this->validate(request(),[
            'roles'=>'required|array'
        ]);
        // fandMany roles传递的是id数组
        //获取前端传递的角色
        $roles = AdminRole::findMany(request('roles'));
        //获取当前用户的角色
        $myRoles = $user->roles;

        //要增加
            //差集
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role){
            $user->assignRole($role);
        }
        //要删除
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role){
            $user->deleteRole($role);
        }
        return back();
    }
}