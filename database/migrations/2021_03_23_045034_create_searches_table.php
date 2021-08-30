<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('orign_name')->nullable();
            $table->decimal('orign_lat', 10, 7)->nullable();
            $table->decimal('orign_long', 10, 7)->nullable();
            $table->string('destination_name')->nullable();
            $table->decimal('destination_lat', 10, 7)->nullable();
            $table->decimal('destination_long', 10, 7)->nullable();
            $table->integer('miles')->nullable();
            $table->text('equipment')->nullable();
            $table->string('pickup_date')->nullable();
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
        Schema::dropIfExists('searches');
    }
}
