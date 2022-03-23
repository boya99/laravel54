<?php
//test模块
namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class PracticeController extends Controller{

    //测试路由
    public function viewtest(){

        $data = [
            ['title'=>'英雄传'],
            ['title'=>'李小璐'],
            ['title'=>'网费'],
            ['title'=>'费德勒'],
        ];
        //建议数组合并，页面渲染变量名传递一致 $data
        return view('test/viewtest',['title'=>'this is title','isShow'=>false,'data'=>$data]);
    }
    //测试使用compact拼装数组 传递路由参数
    public function compactRoute(){
        $data = [
            ['title'=>'英雄传'],
            ['title'=>'李小璐'],
            ['title'=>'网费'],
            ['title'=>'费德勒'],
        ];
        $title = '这是后台传递参数';
        $isShow = true;
        //建议数组合并，使用compact('变量名称')，返回数组
        return view('test/compactRoute',compact('data','title','isShow'));
    }

    //测试路由 分片传递参数
    public function moreData(){

        $data = [
            ['title'=>'英雄传'],
            ['title'=>'李小璐'],
            ['title'=>'网费'],
            ['title'=>'费德勒'],
        ];
        $title = '多测试路由';
        //建议数组合并，页面渲染变量名传递一致 $data
        $view = view('test/moreData');

        $view->with('data',$data);
        $view->with('title',$title);
        return $view;
    }
}