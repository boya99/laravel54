<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
//        是否存在表 字段
        if (!Schema::hasColumn('flights', 'email')) {
            Schema::table('flights', function (Blueprint $table) {
                $table->string('email')->default('');
            });
        }
        if (Schema::hasColumn('flights', 'name')) {
            Schema::table('flights', function (Blueprint $table) {
                $table->string('name', 50)->comment('姓名')->default('')->change();
            });
        }
//        if (Schema::hasColumn('flights', 'sex')) {
            Schema::table('flights', function (Blueprint $table) {
                $table->dropColumn('sex');
            });
//        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasColumn('flights', 'sex')) {
            Schema::table('flights', function (Blueprint $table) {
                $table->dropColumn('sex');
            });
        }

    }
}
