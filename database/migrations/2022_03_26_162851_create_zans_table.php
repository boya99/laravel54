<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //是否有数据表
        if (!Schema::hasTable('zans')) {
            Schema::create('zans', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('post_id')->default(0)->comment('文章id');
                $table->integer('user_id')->default(0)->comment('用户id');
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
        Schema::dropIfExists('zans');
    }
}
