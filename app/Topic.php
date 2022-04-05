<?php

namespace App;

use App\Model;

class Topic extends Model
{
//    专题文章 多对多 模型
    public function  posts(){
//       专题表 多对多 文章表  这2个表的关联表：post_topics
//        第一个参数文章表  第二个参数 文章与专题的关联关系表   第三个参数关联关系表中对专题的外键  第四个参数关联关系表中对文章的外键
        return $this->belongsToMany(Post::class,'post_topics','topic_id','post_id');

    }
    //专题的文章数 用于withcount
    public function postTopics(){
       return  $this->hasMany(PostTopic::class,'topic_id');
    }
}
