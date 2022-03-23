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
}
