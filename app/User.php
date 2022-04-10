<?php

namespace App;

use App\Model;
//用户权限继承
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
//    不能继承 App/Model 只能自己手动添加

    //允许通过数组注入的字段,需要指定，   白名单
    protected $fillable = [
        'name','email','password'
    ];

    //用户的文章列表
    public function posts(){
        return $this->hasMany(Post::class,'user_id','id');
    }
    //我的粉丝
    public function fans(){
        return $this->hasMany(Fan::class,'star_id','id');
    }

    //我的关注Fan 模型
    public function stars(){
        return $this->hasMany(Fan::class,'fans_id','id');
    }
    //我关注某人
    public function doFan($uid){
        $fan = new Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }

    //取消关注
    public function doUnFan($uid){
        $fan = new Fan();
        $fan->star_id = $uid;
        return $this->stars()->delete($fan);
    }

//    当前用户是否被uid关注了(uid 是我的粉丝)
    public function hasFan($uid){
        return $this->fans()->where('fan_id',$uid)->count();
    }

    //当前用户是否关注了$uid（我是uid的粉丝）
    public function hasStar($uid){
        return $this->stars()->where('star_id',$uid)->count();
    }

}
