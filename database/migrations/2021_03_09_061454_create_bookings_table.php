<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id')->nullable()->comment('post load id');
            $table->integer('vehicle_id')->nullable()->comment('truck post id');
            $table->integer('posted_by');
            $table->integer('requested_by');
            $table->decimal('pickup_lat', 10, 7);
            $table->decimal('pickup_long', 10, 7);
            $table->decimal('destination_lat', 10, 7);
            $table->decimal('destination_long', 10, 7);
            $table->boolean('approved')->comment('Pending=1 Accepted=2 Hired=3')->default(0);
            $table->boolean('status')->comment('startride=1 completed=2')->default(0);
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
        Schema::dropIfExists('bookings');
    }
}
