<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('topics')){
            Schema::create('topics',function (Blueprint $table){
                $table->increments('id');
                $table->string('name',30)->default('')->comment('专题名称');
//            timestamps 函数默认方法增加 created_at and updated_at 2个时间字段
                $table->timestamps();

            });
            DB::statement("ALTER TABLE `topics` COMMENT '专题表'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
