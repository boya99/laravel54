<?php

namespace App\Http\Controllers;

use App\PostTopic;
use App\Topic;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
   public function index()
   {
       //获取当前用户
       $user = Auth::user();
       $notices = $user->notices;
       $title = '通知列表页';
       return view('notice/index',compact('notices','title'));
   }
}
