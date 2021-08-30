<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('posted_by');
            $table->string('orign_name');
            $table->decimal('orign_lat', 10, 7)->nullable();
            $table->decimal('orign_long', 10, 7)->nullable();
            $table->string('destination_name')->nullable();
            $table->decimal('destination_lat', 10, 7)->nullable();
            $table->decimal('destination_long', 10, 7)->nullable();
            $table->integer('miles');
            $table->string('available_date');
            $table->string('equipment');
            $table->string('load_size');
            $table->decimal('lenght', 11,2);
            $table->decimal('hieght', 11,2);
            $table->decimal('width', 11,2);
            $table->string('vehicle_brand');
            $table->string('vehicle_number')->nullable();
            $table->text('description')->nullable();
            $table->decimal('set_price', 11,2);
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
