<?php

namespace App\Http\Controllers;

use App\PostTopic;
use App\Topic;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    //专题显示
    public function show(Topic $topic)
    {
        $title = '专题页';
        //获取带文章的专题 topic模型调用 postTopics方法(一对多)  统计
        $topic = Topic::withCount('postTopics')->find($topic->id);
        //专题的文章列表 按照排列创建时间排列 前10个
        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();

        //属于我的文章，但是未投稿  调用 post模型中 scopeAuthorBy 和 scopeTopicNotBy 方法
        $myposts = Post::authorBY(Auth::id())->topicNotBy($topic->id)->get();

//        dump($posts);
//        dump($myposts);
//        print_r(DB::getQueryLog());
//        exit;
        return view("topic/show", compact('title', 'topic', 'posts','myposts'));
    }

//    投稿行为
    public function submit(Topic $topic)
    {
        $this->validate(\request(),[
            'post_ids'=>'required|array'
        ]);
        $post_ids = \request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id){
            PostTopic::firstOrCreate(compact('topic_id','post_id'));
        }
        return back();
    }
}
