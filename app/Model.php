<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    //默认 post对应的数据表就是posts
    //如果没有对应需要手动指定 $table 表名是 my_flights

    //    protected $table = 'my_flights';

//    不允许注入的字段 [] 空数组表示所有字段都可以注入
    protected $guarded = [];
    //允许通过数组注入的字段,需要指定，比较繁琐
//    protected $fillable = ['title','content'];
}