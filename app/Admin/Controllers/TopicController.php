<?php
namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUsers;
use App\Topic;

class TopicController extends controller
{
    //专题列表页面
    public function index()
    {

         $topics = Topic::all();
        return view('admin/topic/index',compact('topics'));
    }

    //专题创建页面
    public function create()
    {
        return view('admin/topic/create');

    }
    //创建操作
    public function store(){

        $this->validate(request(),[
            'name'=>'required|string'
        ]);
        Topic::create(['name'=>request('name')]);
        return redirect('admin/topics');
    }

    //用户展示角色页面
    public function destroy(Topic $topic )
    {
        $topic->delete();
        return [
            'error'=>0,
            'msg'=>''
        ];

    }

}