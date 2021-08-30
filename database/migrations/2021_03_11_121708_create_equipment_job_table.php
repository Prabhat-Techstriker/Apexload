<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_job', function (Blueprint $table) {
            $table->id();
            /*$table->integer('equipment_id');
            $table->integer('job_id');*/
        $table->biginteger('equipment_id')->unsigned()->index();
        $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
        $table->biginteger('job_id')->unsigned()->index();
        $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_job');
    }
}
