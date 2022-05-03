<?php
namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUsers;
use App\Jobs\Sendmessage;
use App\Notice;
use App\Topic;

class NoticeController extends controller
{
    //专题列表页面
    public function index()
    {

         $notices = Notice::paginate(15);

        return view('admin/notice/index',compact('notices'));
    }

    //专题创建页面
    public function create()
    {
        return view('admin/notice/create');

    }
    //创建操作
    public function store(){

        $this->validate(request(),[
            'title'=>'required|string',
            'content'=>'required|string'
        ]);
        $notice = Notice::create(request(['title','content']));
        $msg = new Sendmessage($notice);//注册job
        dispatch($msg);//分发队列
        return redirect('admin/notices');
    }



}