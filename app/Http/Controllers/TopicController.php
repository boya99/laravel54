<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    //专题显示
    public function show(Topic $topic)
    {
        $title  = '专题页';
        return view("topic/show",compact('title'));
    }

//    投稿行为
    public function submit(Topic $topic)
    {
        return;
    }
}
