<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_vehicle', function (Blueprint $table) {
            $table->id();
            /*$table->integer('equipment_id');
            $table->integer('vehicle_id');*/
        $table->biginteger('equipment_id')->unsigned()->index();
        $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
        $table->biginteger('vehicle_id')->unsigned()->index();
        $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_vehicle');
    }
}
