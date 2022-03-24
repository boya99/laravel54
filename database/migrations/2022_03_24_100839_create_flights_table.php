<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        // 判断数据表是否存在
        if (!Schema::hasTable('flights')) {
            Schema::create('flights', function (Blueprint $table) {
                $table->engine = 'InnoDB';//设置存储引擎
                $table->increments('id');
                $table->string('name', 100)->comment('姓名')->default('');//相当于 VARCHAR 型态，并带有长度。
                //相当于 TEXT 型态。 允许 null
                $table->text('description')->comment('个人描述')->nullable();;
                $table->enum('sex', ['man', 'woman'])->comment('性别');
                $table->timestamps();//加入 created_at 和 updated_at 字段。
                $table->softDeletes();//加入 deleted_at 字段用于软删除操作。


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
        //
    }
}
