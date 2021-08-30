<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateToJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('load')->nullable()->change();
            $table->string('weight')->nullable()->change();
            $table->string('lenght')->nullable()->change();
            $table->string('hieght')->nullable()->change();
            $table->string('width')->nullable()->change();
            $table->string('pieces')->nullable()->change();
            $table->string('quantity')->nullable()->change();
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
            //
        });
    }
}
