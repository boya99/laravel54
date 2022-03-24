<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *用于添加新的数据表， 字段或者索引到数据库
     * @return void
     */
    public function up()
    {
        //是否有数据表
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                    $table->increments('id');
//            string 相当于 mysql 中的varchar
                    $table->string('title',100)->default('');
                    $table->text('content');
                    $table->integer('user_id')->default(0);
//            timestamps 函数默认方法增加 created_at and updated_at 2个时间字段
                    $table->timestamps();
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
