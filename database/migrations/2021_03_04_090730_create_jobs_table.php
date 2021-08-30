<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('posted_by');
            $table->string('orign_name');
            $table->decimal('orign_lat', 10, 7);
            $table->decimal('orign_long', 10, 7);
            $table->string('destination_name');
            $table->decimal('destination_lat', 10, 7);
            $table->decimal('destination_long', 10, 7);
            $table->integer('miles');
            $table->string('pickup_date');
            $table->string('equipment');
            $table->decimal('load', 11,2);
            $table->decimal('weight', 11,2);
            $table->decimal('lenght', 11,2);
            $table->decimal('hieght', 11,2);
            $table->decimal('width', 11,2);
            $table->decimal('pieces', 11,2);
            $table->integer('quantity');
            $table->string('com_name')->nullable();
            $table->string('com_email')->nullable();
            $table->string('com_phone')->nullable();
            $table->string('com_office')->nullable();
            $table->string('com_fax')->nullable();
            $table->string('per_user')->nullable();
            $table->string('per_phone')->nullable();
            $table->string('per_email')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}