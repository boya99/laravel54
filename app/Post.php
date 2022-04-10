<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;

class Post extends Model
{
//    使用scout 下的searchable   符合scout的规范
    use Searchable;
    //定义索引里面的type 相当于定义一个表
    public function searchableAs()
    {
        return "post";
    }
//    定义有哪些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'title'=>$this->title,
            'content'=>$this->content,
            'created_at'=>$this->created_at,
        ];
    }


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


    //    属于某个作者的文章  属于不属于的 scopeAuthorBy 特有语法 必须scope开头
    public function scopeAuthorBy(Builder $query, $user_id)
    {

        return $query->where('user_id', $user_id);
    }

//    一篇文章对应多个专题关联关系  一对多
    public function postTopics(){
        return $this->hasMany('App\PostTopic','post_id','id');
    }

//    Laravel中模型中可以定义scope开头方法，这类方法可以通过模型直接调用。这类方法也称作查询作用域。
//laravel中要求在定义的方法scope后面跟的字母要大写(小驼峰命名法)
//
//后面那我们去控制器进行处理数据
//在控制器中使用:去除scope前缀,首字母变小写调用就好啦.
//
//定义范围后，可以在查询模型时调用范围方法。但是，scope调用方法时不应包含前缀。您甚至可以将调用链接到各种范围
//    不属于某个专题的文章
    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
//        doesntHave:不属于  postTopics  上方的关联模型   and 并且  回调方法   use($topic_id) 匿名函数传递外部参数
        return $query->doesntHave('postTopics','and',function($q) use($topic_id){
            $q->where('topic_id',$topic_id);
        });
    }



    //全局scope的方式  只要跟post模型相关的查询都会 以status 为0 1 为查询
    /*
    我们需要重新定义 boot 方法，集成父类 boot 以后，添加全局 scope，这样默认就已经全局使用了。

    那么，我们有的时候有的查询是不需要这个全局 scope 的时候怎么办呢？去掉就可以

    $posts = Post::withOutGlobalScope('avaiable')->orderBy('created_at','desc')->paginate(10);



     * */
    protected static function boot(){
        parent::boot();
        static::addGlobalScope('avaiable',function(Builder $builder){
            $builder->whereIn('status',[0,1]);
        });
    }
}
