<?php

namespace App;


use App\Model;
class Fan extends Model
{
    //粉丝用户
    public function fuser(){
        return $this->hasOne('App\User','id','fans_id');
    }
    //被关注的用户
    public function suser(){
        return $this->hasOne(User::class,'id','star_id');
    }
}
