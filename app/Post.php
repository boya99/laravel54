<?php

namespace App;

use App\Model;

class Post extends Model
{
    //默认 post对应的数据表就是posts
    //如果没有对应需要手动指定 $table 表名是 my_flights
   //    protected $table = 'my_flights';

//    不允许注入的字段 [] 空数组表示所有字段都可以注入
//    protected $guarded = [];
    /**
     * 允许通过数组注入的字段 需要指定，比较繁琐，
     * $fillable ，$guarded 可以同时存在，也可以只保留 $guarded = [],这样就不限制
     * 所以从新写一个model,用来继承，可以一劳永逸
     */
//    protected $fillable = ['title','content'];


    //模型关联用户表user 一对一 文章模型关联
    public function user(){
//        默认情况下匹配 Post 模型的 user_id 至 User 模型的 id
//        return $this->belongsTo('App\User');
//        相当于 Post表的user_id字段 对应 user表中的id   一对一
        return $this->belongsTo('App\User','user_id','id');
    }
}
