<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CereteNullableFleidsVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('destination_name')->nullable()->change();
            $table->decimal('destination_lat', 10, 7)->nullable()->change();
            $table->decimal('destination_long', 10, 7)->nullable()->change();
            $table->string('vehicle_brand')->nullable()->change();
            $table->decimal('set_price', 11,2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            //
        });
    }
}
