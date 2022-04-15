<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionAndRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //角色表
        if(!Schema::hasTable('admin_roles')){
            Schema::create('admin_roles',function (Blueprint $table){
                $table->engine = 'InnoDB';//设置存储引擎
                $table->increments('id');
                $table->string('name',30)->default('')->comment('角色');
                $table->string('description',100)->default('')->comment('角色描述');

//            timestamps 函数默认方法增加 created_at and updated_at 2个时间字段
                $table->timestamps();

            });
            DB::statement("ALTER TABLE `admin_roles` COMMENT '角色表'");
        }
        //权限表
        if(!Schema::hasTable('admin_permissions')){
            Schema::create('admin_permissions',function (Blueprint $table){
                $table->engine = 'InnoDB';//设置存储引擎
                $table->increments('id');
                $table->string('name',30)->default('')->comment('权限名称');
                $table->string('description',100)->default('')->comment('权限描述');

                $table->timestamps();

            });
            DB::statement("ALTER TABLE `admin_permissions` COMMENT '权限表'");
        }
        //权限角色表
        if(!Schema::hasTable('admin_permission_role')){
            Schema::create('admin_permission_role',function (Blueprint $table){
                $table->engine = 'InnoDB';//设置存储引擎
                $table->increments('id');
                $table->integer('role_id')->default('0')->comment('角色id');
                $table->integer('permission_id')->default('0')->comment('权限id');
                $table->timestamps();

            });
            DB::statement("ALTER TABLE `admin_permission_role` COMMENT '权限角色表'");
        }
        //用户角色表
        if(!Schema::hasTable('admin_role_user')){
            Schema::create('admin_role_user',function (Blueprint $table){
                $table->engine = 'InnoDB';//设置存储引擎
                $table->increments('id');
                $table->integer('role_id')->default('0')->comment('角色id');
                $table->integer('user_id')->default('0')->comment('用户id');
                $table->timestamps();

            });
            DB::statement("ALTER TABLE `admin_role_user` COMMENT '用户角色表'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_permissions');
        Schema::dropIfExists('admin_permission_role');
        Schema::dropIfExists('admin_role_user');

    }
}
