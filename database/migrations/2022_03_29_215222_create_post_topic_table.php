<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePostTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('post_topics')){
            Schema::create('post_topics',function (Blueprint $table){
                $table->increments('id');
                $table->integer('post_id')->default(0)->comment('文章id');
                $table->integer('topic_id')->default(0)->comment('文章id');
//            timestamps 函数默认方法增加 created_at and updated_at 2个时间字段
                $table->timestamps();

            });
            DB::statement("ALTER TABLE `post_topics` COMMENT '文章专题关联关系表'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_topics');
    }
}
