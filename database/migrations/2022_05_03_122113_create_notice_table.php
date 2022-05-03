<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //通知表表
        if(!Schema::hasTable('notices')){
            Schema::create('notices',function (Blueprint $table){
                $table->engine = 'InnoDB';//设置存储引擎
                $table->increments('id');
                $table->string('title',50)->default('')->comment('标题');
                $table->string('content',255)->default('')->comment('标题内容');

//            timestamps 函数默认方法增加 created_at and updated_at 2个时间字段
                $table->timestamps();

            });
            DB::statement("ALTER TABLE `notices` COMMENT '通知表'");
        }

        //用户通知关系表
        if(!Schema::hasTable('user_notice')){
            Schema::create('user_notice',function (Blueprint $table){
                $table->engine = 'InnoDB';//设置存储引擎
                $table->increments('id');
                $table->integer('user_id')->default(0)->comment('用户id');
                $table->integer('notice_id')->default(0)->comment('通知id');

//            timestamps 函数默认方法增加 created_at and updated_at 2个时间字段
                $table->timestamps();

            });
            DB::statement("ALTER TABLE `user_notice` COMMENT '用户通知关系表'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('notices');
        Schema::dropIfExists('user_notice');
    }
}
