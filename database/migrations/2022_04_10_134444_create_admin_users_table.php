<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //对应的模型：AdminUsers
        if(!Schema::hasTable('admin_users')){
            Schema::create('admin_users',function (Blueprint $table){
                $table->increments('id');
                $table->string('name',30)->default('')->comment('用户名');
                $table->string('password',100)->default('')->comment('密码');

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
        Schema::dropIfExists('admin_users');
    }
}
