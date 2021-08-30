<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsDefaultToJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->decimal('load', 11,2)->nullable()->change();
            $table->decimal('weight', 11,2)->nullable()->change();
            $table->decimal('lenght', 11,2)->nullable()->change();
            $table->decimal('hieght', 11,2)->nullable()->change();
            $table->decimal('width', 11,2)->nullable()->change();
            $table->decimal('pieces', 11,2)->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->string('equipment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            /*$table->dropColumn('load');
            $table->dropColumn('weight');
            $table->dropColumn('lenght');
            $table->dropColumn('hieght');
            $table->dropColumn('width');
            $table->dropColumn('pieces');
            $table->dropColumn('quantity');
            $table->dropColumn('equipment');*/
        });
    }
}
