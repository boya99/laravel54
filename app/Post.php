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


    //模型关联用户表user 反向模型关联
    public function user(){
//        默认情况下匹配 Post 模型的 user_id 至 User 模型的 id
//        return $this->belongsTo('App\User');
//        相当于 Post表的user_id字段 对应 user表中的id   一对一
//        查询 post表中的user_id字段跟 User表中的id 匹配
//        反向思维
//        第二个参数：父模型Post为主 关联子模型User 其中找到父模型的外键 user_id 对应的是 子模型user的id
//        Eloquent 会尝试匹配 Post 模型的 user_id 至 User 模型的 id
//        会尝试将 Post 模型的 user_id 与 User 模型的 id 进行匹配。Eloquent 判断的默认外键名称参考自关联模型的方法，并在方法名称后面加上 _id
        return $this->belongsTo('App\User','user_id','id');
    }

//    一对多关联 评论模型
    public function comments(){
//        第三个参数默认是当前post模型的主键 id
//        正向一对多，自动判断 Comment 模型上正确的外键字段 为post_id   父模型:id
//        会自动判断 Comment 模型上正确的外键字段。
//         按约定来说，Eloquent 会取用后方加上 _id。所以， Comment 模型的外键是 post_id。
//
        return $this->hasMany('App\Comment','post_id','id')->orderBy('id','desc');
    }

//  和用户进行关联   这篇文章，对这个用户是否有赞,参数为用户id,
    public function zan($user_id){
        return $this->hasOne(Zan::class)->where('user_id',$user_id);
    }
//    这篇文章所有的赞
    public function zans(){
        return $this->hasMany(Zan::class);
    }
}
